<?php

namespace App\Command;

use App\Stats\StatsServiceInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatsResetCommand extends Command
{
    protected static $defaultName = 'quiz:stats:reset';

    public function __construct(
        protected StatsServiceInterface $statsService
    ){
        parent::__construct();
    }

    protected function configure()
    {
        $this->setAliases(['3', 'stats-reset']);
        $this->setDescription('Resets statistics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->info('Clearing stats...');

        try {
            $this->statsService->resetStatsFile();
        } catch(Exception $exception) {
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('Stats have been reset');
        return Command::SUCCESS;
    }
}