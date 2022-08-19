<?php

namespace App\Question\Exception;

use App\Question\AnswerCollection;
use App\Question\Question;
use Exception;

class WrongAnswerCountException extends Exception
{
    public function __construct(Question $question)
    {
        $message = sprintf(
            'Answer count for question (%s) is invalid. Provided: %s, expected: %s.',
            $question->getQuestion(),
            $question->getAnswers()->count(),
            Question::CORRECT_ANSWER_COUNT
        );
        parent::__construct($message, 400);
    }
}