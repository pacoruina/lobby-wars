<?php
declare(strict_types=1);

namespace LobbyWars\Infrastructure\CliCommand;

use LobbyWars\Application\GetTrialWinnerQuery;
use LobbyWars\Application\GetTrialWinnerQueryHandler;
use LobbyWars\Domain;
use LobbyWars\Infrastructure\Provider\DependenciesProvider;
use Symfony\Component\Console\Input;
use Symfony\Component\Console\Output;

class PlayTrialCommand extends TrialCommand
{
    const CLI_COMMAND_NAME = 'trial:play';

    protected function configure()
    {
        $this
            ->setName(self::CLI_COMMAND_NAME)
            ->setDescription('Play a Trial on the Lobby Wars')
            ->addArgument('plaintiff', Input\InputArgument::REQUIRED, 'Plaintiff')
            ->addArgument('defendant', Input\InputArgument::REQUIRED, 'Defendant');
    }

    protected function execute(Input\InputInterface $input, Output\OutputInterface $output)
    {
        try {
            /** @var GetTrialWinnerQueryHandler $getTrialWinnerQueryHandler */
            $getTrialWinnerQueryHandler = $this->container->get(DependenciesProvider::GET_TRIAL_WINNER_QUERY_HANDLER);

            $query = $this->composeGetTrialWinnerQuery(
                $input->getArgument('plaintiff'),
                $input->getArgument('defendant')
            );

            $output->writeln($getTrialWinnerQueryHandler($query)->getWinnerId());
        } catch (\Throwable $throwable) {
            $output->writeln('<error>' . $throwable->getMessage() . '</error>');
        }
    }

    private function composeGetTrialWinnerQuery(string $plaintiffInput, string $defendantInput): GetTrialWinnerQuery
    {
        return new GetTrialWinnerQuery(
            $this->composeContract('plaintiff', $plaintiffInput),
            $this->composeContract('defendant', $defendantInput)
        );
    }
}
