<?php

namespace App\Question;

use App\Struct\Collection;

class QuestionCollection extends Collection
{
    /** @param array<Question> $questions */
    public function setQuestions(array $questions): void
    {
        $this->items = $questions;
    }

    public function addQuestion(Question $question): QuestionCollection
    {
        $this->items[] = $question;
        return $this;
    }
}