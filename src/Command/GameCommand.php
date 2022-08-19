<?php

namespace App\Command;

use App\Command\CommandQuestion\PlayAgainQuestion;
use App\Command\CommandQuestion\PlayerCountQuestion;
use App\Command\CommandQuestion\PlayerNameQuestion;
use App\Command\CommandQuestion\QuizQuestion;
use App\Game\Exception\ExceptionHelper;
use App\Game\Game;
use App\Game\GameStatesEnum;
use App\Player\Player;
use App\Player\PlayerCollection;
use App\Question\Question;
use App\Stats\StatsServiceInterface;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GameCommand extends Command
{
    protected static $defaultName = 'quiz:play';
    protected QuestionHelper $questionHelper;
    protected SymfonyStyle $io;

    public function __construct(
        protected Game $game,
        protected StatsServiceInterface $statsService
    ){
        parent::__construct();
    }

    protected function configure()
    {
        $this->setAliases(['1', 'start']);
        $this->setDescription('Starts quiz game');
        $this->setHelperSet(new HelperSet([new QuestionHelper()]));
        $this->questionHelper = $this->getHelper('question');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->updateState(GameStatesEnum::CONFIGURATION);
        $this->configureGame($input, $output);
        return $this->play( $input, $output);
    }

    private function play(InputInterface $input, OutputInterface $output): int
    {
        //players will be randomly sorted
        $this->game->getPlayers()->shuffle();

        try {
            $this->game->initQuestions();
        } catch(BadResponseException $exception) {
            $this->io->error(ExceptionHelper::getGuzzleExceptionAsArray($exception));
            return Command::FAILURE;
        } catch(\Exception $exception) {
            $this->io->error(ExceptionHelper::getExceptionAsArray($exception));
            return Command::FAILURE;
        }

        /** @var Question $question */
        foreach ($this->game->getQuestions() as $question) {
            /** @var Player $player */
            foreach ($this->game->getPlayers() as $player) {
                $this->updateState(GameStatesEnum::ASKED_QUESTION);
                $choice = $this->questionHelper->ask($input, $output, new QuizQuestion($question, $player));
                $this->updateState(GameStatesEnum::ANSWERED_QUESTION);

                if ($choice === $question->getCorrectAnswer()->getIdentifier()) {
                    $player->increaseCorrectAnswers();
                }
            }
        }

        $this->updateState(GameStatesEnum::UPDATING_STATS);
        $this->statsService->updateStatsFile($this->game->getPlayers());

        $this->updateState(GameStatesEnum::GENERATING_RANK);
        $this->io->note('Finished. Player results: ');;

        $winners = new PlayerCollection();
        $winnerHighscore = 0;

        foreach ($this->game->getPlayers() as $player) {
            if ($winnerHighscore < $player->getCorrectAnswers()) {
                $winners = new PlayerCollection();
                $winnerHighscore = $player->getCorrectAnswers();
            }

            if($winnerHighscore === $player->getCorrectAnswers()) {
                $winners->addPlayer($player);
            }

            $this->io->writeln(sprintf(
                'Player "%s" has scored %s point(s)',
                $player->getName(),
                $player->getCorrectAnswers()
            ));
        }

        if ($winnerHighscore === 0) {
            $this->io->error('Nobody won! :(');
        } else {
            $this->io->success(sprintf(
                'Winners: %s. Congratulations with score: %s',
                $winners->getAllPlayerNames(),
                $winnerHighscore
            ));
        }

        if($this->questionHelper->ask($input, $output, new PlayAgainQuestion())) {
            $this->game->getPlayers()->resetScores();
            return $this->play($input, $output);
        }

        $this->io->success('Thanks for playing!');
        return Command::SUCCESS;
    }

    private function configureGame(InputInterface $input, OutputInterface $output)
    {
        $playerCount = $this->questionHelper->ask($input, $output, new PlayerCountQuestion());
        $this->game->setPlayerCount($playerCount);

        $playerCollection = new PlayerCollection();

        //ask player names
        for ($i = 1; $i <= $playerCount; $i++) {
            $playerName = $this->questionHelper->ask($input, $output, new PlayerNameQuestion($i));
            $player = (new Player())
                ->setId($i)
                ->setName($playerName);

            $playerCollection->addPlayer($player);
        }

        $this->game->setPlayers($playerCollection);
    }

    private function updateState(GameStatesEnum $gameState): void
    {
        $this->game->setGameStatesEnum($gameState);
        $this->io->writeln(sprintf(
            PHP_EOL . '=== STATE: %s ===' . PHP_EOL,
            $this->game->getGameState()->value
        ));
    }
}