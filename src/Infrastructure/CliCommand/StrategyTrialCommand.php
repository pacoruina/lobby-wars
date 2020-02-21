<?php
declare(strict_types=1);

namespace LobbyWars\Infrastructure\CliCommand;

use LobbyWars\Application\GetMinimumRoleToWinTheTrialQuery;
use LobbyWars\Application\GetMinimumRoleToWinTheTrialQueryHandler;
use LobbyWars\Domain;
use LobbyWars\Infrastructure\Provider\DependenciesProvider;
use Symfony\Component\Console\Input;
use Symfony\Component\Console\Output;

class StrategyTrialCommand extends TrialCommand
{
    const CLI_COMMAND_NAME = 'trial:strategy';

    const NO_WAY_MESSAGE = 'No role can win against this opposition contract';

    protected function configure()
    {
        $this
            ->setName(self::CLI_COMMAND_NAME)
            ->setDescription('Plan a Trial Strategy on the Lobby Wars')
            ->addArgument('myContract', Input\InputArgument::REQUIRED, 'myContract')
            ->addArgument('oppositionContract', Input\InputArgument::REQUIRED, 'oppositionContract');
    }

    protected function execute(Input\InputInterface $input, Output\OutputInterface $output)
    {
        try {
            /** @var GetMinimumRoleToWinTheTrialQueryHandler $getMinimumRoleToWinTheTrialQueryHandler */
            $getMinimumRoleToWinTheTrialQueryHandler = $this->container->get(DependenciesProvider::GET_MINIMUM_ROLE_TO_WIN_THE_TRIAL_QUERY_HANDLER);

            $query = $this->composeGetMinimumRoleToWinTheTrialQuery(
                $input->getArgument('myContract'),
                $input->getArgument('oppositionContract')
            );

            if (null !== $getMinimumRoleToWinTheTrialQueryHandler($query)->getRole()) {
                $output->writeln($getMinimumRoleToWinTheTrialQueryHandler($query)->getRole()->getName());
            } else {
                $output->writeln(self::NO_WAY_MESSAGE);
            }
        } catch (\Throwable $throwable) {
            $output->writeln('<error>' . $throwable->getMessage() . '</error>');
        }
    }

    protected function composeGetMinimumRoleToWinTheTrialQuery(
        string $myContractInput,
        string $oppositionContractInput
    ): GetMinimumRoleToWinTheTrialQuery {
        return new GetMinimumRoleToWinTheTrialQuery(
            $this->composeContract('myContract', $myContractInput),
            $this->composeContract('oppositionContract', $oppositionContractInput)
        );
    }
}
