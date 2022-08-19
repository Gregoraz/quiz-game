<?php

namespace App\Stats;

use App\Game\ConfigReader;
use App\Player\Player;
use App\Player\PlayerCollection;

class StatsService implements StatsServiceInterface
{
    public const STATS_DIR = __DIR__ . '/../../';
    public const STATS_FILE_NAME = '/stats.txt';

    /** @var resource|null $file */
    protected $file;

    public function __construct()
    {
        $this->initStatsFile();
    }

    public function __destruct()
    {
        $this->closeStatsFile();
    }

    public function initStatsFile(): void
    {
        $this->file = fopen(realpath(self::STATS_DIR) . self::STATS_FILE_NAME, 'c+');
    }

    public function closeStatsFile(): void
    {
        if($this->file) {
            @fclose($this->file);
        }
    }

    public function resetStatsFile(): void
    {
        file_put_contents(realpath(self::STATS_DIR) . self::STATS_FILE_NAME, '');
    }

    public function getStatsAsArray(): array
    {
        $statsArray = [];
        while (!feof($this->file)) {
            $row = fgets($this->file);
            if($row) {
                $statsArray[] = $row;
            }
        }

        return $statsArray;
    }

    public function updateStatsFile(PlayerCollection $playerCollection): void
    {
        $this->initStatsFile();
        $scoresWithPoints = [];
        $this->fillCurrentScores($scoresWithPoints);
        $this->fillGameScores($scoresWithPoints, $playerCollection);
        $this->sortByScore($scoresWithPoints);
        $scoresWithPoints = array_slice($scoresWithPoints, 0, ConfigReader::getStatsPositions());

        $scoresString = '';
        foreach($scoresWithPoints as $scoreRow) {
            $scoresString .= $scoreRow['name'] . '{{{' . $scoreRow['score'] . '}}}' . PHP_EOL;
        }

        $this->resetStatsFile();
        file_put_contents(realpath(self::STATS_DIR) . self::STATS_FILE_NAME, $scoresString);
    }

    private function fillCurrentScores(array &$scoresWithPoints): void
    {
        $statsArray = $this->getStatsAsArray();
        foreach($statsArray as $statRow) {
            if(!trim($statRow)) {
                continue;
            }
            $scoreStart = strpos($statRow, '{{{');
            $scoreEnd = strpos($statRow, '}}}');
            if($scoreStart && $scoreEnd) {
                $score = (int)substr($statRow, $scoreStart+3, $scoreEnd);
                $playerName = substr($statRow, 0, $scoreStart);
                $scoresWithPoints[] = [
                    'name' => $playerName,
                    'score' => $score
                ];
            }
        }
    }

    private function fillGameScores(array &$scoresWithPoints, PlayerCollection $playerCollection): void
    {
        /** @var Player $player */
        foreach($playerCollection as $player) {
            if($player->getCorrectAnswers() === 0) {
                continue;
            }
            $scoresWithPoints[] = [
                'name' => $player->getName(),
                'score' => $player->getCorrectAnswers()
            ];
        }
    }

    private function sortByScore(&$scoresWithPoints): void
    {
        usort($scoresWithPoints, function($row1, $row2) {
           $score1 = $row1['score'];
           $score2 = $row2['score'];

           if($score1 === $score2) {
               return 0;
           }

           return $score1 > $score2 ? -1 : 1;
        });
    }
}