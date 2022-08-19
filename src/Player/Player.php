<?php

namespace App\Player;

use App\Struct\Struct;

class Player extends Struct
{
    protected int $id;
    protected string $name;
    protected int $correctAnswers;

    public function __construct()
    {
        $this->correctAnswers = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Player
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Player
    {
        $this->name = $name;
        return $this;
    }

    public function increaseCorrectAnswers(): Player
    {
        $this->correctAnswers++;
        return $this;
    }

    public function getCorrectAnswers(): int
    {
        return $this->correctAnswers;
    }

    public function setCorrectAnswers(int $correctAnswers): Player
    {
        $this->correctAnswers = $correctAnswers;
        return $this;
    }
}