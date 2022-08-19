<?php

namespace App\Game;

use App\Game\Exception\InvalidConfigException;

class ConfigReader
{
    public static function getQuestionAmount(): int
    {
        return (int)$_ENV['QUESTION_AMOUNT'];
    }

    public static function getTriviaApiHost(): string
    {
        return $_ENV['TRIVIA_API_HOST'];
    }

    public static function getTriviaCategoryNumber(): int
    {
        return (int)$_ENV['TRIVIA_API_CATEGORY'];
    }

    public static function getStatsPositions(): int
    {
        return (int)$_ENV['STATS_POSITIONS'];
    }

    public static function validateConfig(): void
    {
        $questionAmount = $_ENV['QUESTION_AMOUNT'] ?? 0;

        if((int)$questionAmount <= 0) {
            throw new InvalidConfigException('QUESTION_AMOUNT', 'int<positive>');
        }

        $triviaApiCategory = $_ENV['TRIVIA_API_CATEGORY'] ?? 0;
        if((int)$triviaApiCategory <= 0) {
            throw new InvalidConfigException('TRIVIA_API_CATEGORY', 'int<positive>');
        }

        $triviaApiHost = $_ENV['TRIVIA_API_HOST'] ?? null;
        if(!$triviaApiHost || !self::isUrlValid((string)$triviaApiHost)) {
            throw new InvalidConfigException('TRIVIA_API_HOST', 'string<validUrl>');
        }

        $statsPositions = $_ENV['STATS_POSITIONS'] ?? null;
        if((int)$statsPositions <= 0) {
            throw new InvalidConfigException('STATS_POSITIONS', 'int<positive>');
        }
    }

    private static function isUrlValid(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}