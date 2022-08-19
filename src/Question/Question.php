<?php

namespace App\Question;

use App\Struct\Struct;

class Question extends Struct
{
    public const CORRECT_ANSWER_COUNT = 4;

    protected string $question;
    protected AnswerCollection $answers;
    protected Answer $correctAnswer;

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): Question
    {
        $this->question = $this->decodeText($question);
        return $this;
    }

    public function getAnswers(): AnswerCollection
    {
        return $this->answers;
    }

    public function setAnswers(AnswerCollection $answers): Question
    {
        $this->answers = $answers;
        return $this;
    }

    public function getCorrectAnswer(): Answer
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(Answer $correctAnswer): Question
    {
        $this->correctAnswer = $correctAnswer;
        return $this;
    }


}