<?php

namespace App\Command\CommandQuestion;

use Symfony\Component\Console\Question\ChoiceQuestion;

class PlayerCountQuestion extends ChoiceQuestion
{
    public const QUESTION_TEXT = 'How many players?';

    public function __construct()
    {
        parent::__construct(self::QUESTION_TEXT, self::choices());
        $this->setErrorMessage(
            sprintf(
                'Player count invalid. Valid: %s',
                implode(', ', self::choices())
            )
        );
    }

    protected static function choices(): array
    {
        return [
          '1' => 1,
          '2' => 2,
          '3' => 3,
          '4' => 4
        ];
    }
}