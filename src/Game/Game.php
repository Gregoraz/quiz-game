<?php

namespace App\Game;

use App\Player\Player;
use App\Player\PlayerCollection;
use App\Question\Question;
use App\Question\QuestionCollection;
use App\QuestionProvider\QuestionProviderInterface;
use App\QuestionProvider\TriviaQuestionProvider;

final class Game
{
    private int $playerCount;
    private PlayerCollection $players;
    private QuestionCollection $questions;
    private GameStatesEnum $gameState;

    public function __construct(
        private readonly QuestionProviderInterface $questionProvider
    ){
        $this->gameState = GameStatesEnum::START;
    }

    public function getPlayerCount(): int
    {
        return $this->playerCount;
    }

    public function setPlayerCount(int $playerCount): void
    {
        $this->playerCount = $playerCount;
    }

    public function getPlayers(): PlayerCollection
    {
        return $this->players;
    }

    public function setPlayers(PlayerCollection $players): void
    {
        $this->players = $players;
    }

    public function getQuestions(): QuestionCollection
    {
        return $this->questions;
    }

    public function initQuestions(): void
    {
        $questions = $this->questionProvider->getQuestions(ConfigReader::getQuestionAmount());
        $questions->shuffle();
        $this->setQuestions($questions);
    }

    public function setQuestions(QuestionCollection $questionCollection): void
    {
        $this->questions = $questionCollection;
    }

    public function getGameState(): GameStatesEnum
    {
        return $this->gameState;
    }

    public function setGameStatesEnum(GameStatesEnum $gameState): Game
    {
        $this->gameState = $gameState;
        return $this;
    }
}