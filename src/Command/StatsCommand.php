<?php

namespace App\Command;

use App\Stats\StatsServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatsCommand extends Command
{
    protected static $defaultName = 'quiz:stats';

    public function __construct(
        protected StatsServiceInterface $statsService
    ){
        parent::__construct();
    }

    protected function configure()
    {
        $this->setAliases(['2', 'stats']);
        $this->setDescription('Shows statistics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->newLine();
        $io->writeln('=== STATS ===');
        $io->newLine();

        $statsEntries = $this->statsService->getStatsAsArray();

        if(count($statsEntries) === 0) {
            $io->info('No stats yet...');
            return Command::SUCCESS;
        }

        foreach($statsEntries as $statsEntry) {
            $io->writeln($statsEntry);
        }

        $io->success('Play more to get better results :)');

        return Command::SUCCESS;
    }


}