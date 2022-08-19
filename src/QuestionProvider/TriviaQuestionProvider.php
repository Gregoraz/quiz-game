<?php

namespace App\QuestionProvider;

use App\Game\ConfigReader;
use App\Question\Answer;
use App\Question\AnswerCollection;
use App\Question\Exception\WrongAnswerCountException;
use App\Question\Question;
use App\Question\QuestionCollection;
use GuzzleHttp\Client;

class TriviaQuestionProvider implements QuestionProviderInterface
{
    protected string $endpoint;

    public function __construct(
        protected Client $client
    ){
        $this->buildEndpoint();
    }

    public function getQuestions(int $questionNumber): QuestionCollection
    {
        $apiQuestions = $this->getQuestionsFromApi();
        $questionCollection = $this->getQuestionCollectionFromApiData($apiQuestions);
        $this->validateAnswers($questionCollection);
        return $questionCollection;
    }

    private function getQuestionsFromApi(): array
    {
        $result = $this->client->get($this->endpoint);
        return json_decode($result->getBody()->getContents(), true);
    }

    private function getQuestionCollectionFromApiData(array $apiQuestions): QuestionCollection
    {
        $questionCollection = new QuestionCollection();

        foreach ($apiQuestions['results'] as $apiQuestion) {
            $question = (new Question())
                ->setQuestion($apiQuestion['question']);

            $answerCollection = new AnswerCollection();

            $correctAnswer = (new Answer())
                ->setIsCorrect(true)
                ->setAnswerText($apiQuestion['correct_answer']);

            $answerCollection->addAnswer($correctAnswer);
            $question->setCorrectAnswer($correctAnswer);

            foreach($apiQuestion['incorrect_answers'] as $incorrectAnswer) {
                $answerCollection->addAnswer(
                    (new Answer())
                        ->setIsCorrect(false)
                        ->setAnswerText($incorrectAnswer)
                );
            }

            $answerCollection->shuffle();
            $question->setAnswers($answerCollection);

            $questionCollection->addQuestion($question);
        }

        return $questionCollection;
    }

    private function buildEndpoint(): void
    {
        $params = [
            'type' => 'multiple',
            'amount' => ConfigReader::getQuestionAmount(),
            'category' => ConfigReader::getTriviaCategoryNumber()
        ];

        $this->endpoint = ConfigReader::getTriviaApiHost() . '?' . http_build_query($params);
    }

    private function validateAnswers(QuestionCollection $questionCollection): void
    {
        /** @var Question $question */
        foreach($questionCollection as $question) {
            if($question->getAnswers()->count() !== 4) {
                throw new WrongAnswerCountException($question);
            }
        }
    }
}