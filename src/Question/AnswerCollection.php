<?php

namespace App\Question;

use App\Struct\Collection;
use App\Struct\Struct;

class AnswerCollection extends Collection
{
    /** @param array<Answer> $answers */
    public function setAnswers(array $answers): void
    {
        $this->items = $answers;
    }

    public function addAnswer(Answer $answer): AnswerCollection
    {
        $this->items[] = $answer;
        return $this;
    }

    public function getAt(int $key): ?Answer
    {
        return parent::getAt($key);
    }
}