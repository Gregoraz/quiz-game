<?php

namespace App\Question;

use App\Struct\Struct;

class Answer extends Struct
{
    protected string $identifier;
    protected string $answerText;
    protected bool $isCorrect;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): Answer
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getAnswerText(): string
    {
        return $this->answerText;
    }

    public function setAnswerText(string $answerText): Answer
    {
        $this->answerText = $this->decodeText($answerText);
        return $this;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): Answer
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }
}