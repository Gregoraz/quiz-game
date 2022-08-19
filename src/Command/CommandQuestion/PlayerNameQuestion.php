<?php

namespace App\Command\CommandQuestion;

use Symfony\Component\Console\Question\Question;

class PlayerNameQuestion extends Question
{
    public function __construct(int $playerNumber)
    {
        $playerQuestion = sprintf('Player %s name: ', $playerNumber);
        parent::__construct($playerQuestion);
    }
}