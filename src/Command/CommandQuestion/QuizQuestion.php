<?php

namespace App\Command\CommandQuestion;

use App\Player\Player;
use App\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class QuizQuestion extends ChoiceQuestion
{
    public function __construct(Question $question, Player $player)
    {
        parent::__construct(
            sprintf('%s (Player: %s)', $question->getQuestion(), $player->getName()),
            $this->getAnswersFromQuestion($question)
        );

        $this->setErrorMessage('Invalid answer, valid: [A,B,C,D]');
    }

    private function getAnswersFromQuestion(Question $question): array
    {
        $answerCollection = $question->getAnswers();
        return [
          'A' => $answerCollection->getAt(0)->setIdentifier('A')->getAnswerText(),
          'B' => $answerCollection->getAt(1)->setIdentifier('B')->getAnswerText(),
          'C' => $answerCollection->getAt(2)->setIdentifier('C')->getAnswerText(),
          'D' => $answerCollection->getAt(3)->setIdentifier('D')->getAnswerText()
        ];
    }
}