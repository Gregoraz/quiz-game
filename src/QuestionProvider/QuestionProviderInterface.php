<?php

namespace App\QuestionProvider;

use App\Question\Question;
use App\Question\QuestionCollection;

interface QuestionProviderInterface
{
    /**
     * Provides specific amount of questions for the Quiz Game
     *
     * @param int $questionNumber
     * @return QuestionCollection<Question>
     */
    public function getQuestions(int $questionNumber): QuestionCollection;
}