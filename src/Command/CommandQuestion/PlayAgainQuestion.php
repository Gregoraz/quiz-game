<?php

namespace App\Command\CommandQuestion;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class PlayAgainQuestion extends ConfirmationQuestion
{
    public const QUESTION_TEXT = 'Do you want to play again with the same settings but different questions? (y/[n]): ';

    public function __construct()
    {
        parent::__construct(self::QUESTION_TEXT, false);
    }
}