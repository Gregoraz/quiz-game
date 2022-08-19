<?php

namespace App\Stats;

use App\Player\PlayerCollection;

interface StatsServiceInterface
{
    /**
     * Inits stats file (if not exists)
     *
     * @return void
     */
    public function initStatsFile(): void;

    /**
     * Deletes stats file and inits a new one
     *
     * @return void
     */
    public function resetStatsFile(): void;

    /**
     * Updates (if score applies to be written) scores from player collection
     *
     * @param PlayerCollection $playerCollection
     * @return void
     */
    public function updateStatsFile(PlayerCollection $playerCollection): void;

    /**
     * Gets stats as array
     *
     * @return array
     */
    public function getStatsAsArray(): array;
}