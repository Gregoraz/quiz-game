<?php

namespace App\Player;

use App\Struct\Collection;
use App\Struct\Struct;

class PlayerCollection extends Collection
{
    public function setPlayers(array $players): void
    {
        $this->items = $players;
    }

    public function addPlayer(Player $player): PlayerCollection
    {
        $this->items[] = $player;
        return $this;
    }

    public function getAllPlayerNames(): string
    {
        $playerNames = '';

        /** @var Player $player */
        foreach($this->items as $player) {
            $playerNames .= $player->getName() . ', ';
        }

        return trim($playerNames, ', ');
    }

    public function resetScores(): PlayerCollection
    {
        /** @var Player $player */
        foreach($this->items as $player) {
            $player->setCorrectAnswers(0);
        }

        return $this;
    }
}