<?php
declare(strict_types=1);

namespace LobbyWars\Infrastructure\Provider;

use LobbyWars\Application;
use Pimple\Container;
use Psr\Container\ContainerInterface;
use LobbyWars\Infrastructure\CliCommand;

class DependenciesProvider
{
    const PLAY_TRIAL_COMMAND = 'PLAY_TRIAL_COMMAND';
    const STRATEGY_TRIAL_COMMAND = 'STRATEGY_TRIAL_COMMAND';

    const GET_TRIAL_WINNER_QUERY_HANDLER = 'GET_TRIAL_WINNER_QUERY_HANDLER';
    const GET_MINIMUM_ROLE_TO_WIN_THE_TRIAL_QUERY_HANDLER = 'GET_MINIMUM_ROLE_TO_WIN_THE_TRIAL_QUERY_HANDLER';

    public function provide(): ContainerInterface
    {
        $container = new Container();

        // -------- CLI-COMMANDS ----------
        $container[self::PLAY_TRIAL_COMMAND] =
            function (Container $container): CliCommand\PlayTrialCommand {
                return new CliCommand\PlayTrialCommand(
                    new \Pimple\Psr11\Container($container)
                );
            };
        $container[self::STRATEGY_TRIAL_COMMAND] =
            function (Container $container): CliCommand\StrategyTrialCommand {
                return new CliCommand\StrategyTrialCommand(
                    new \Pimple\Psr11\Container($container)
                );
            };

        // -------- COMMAND-QUERY HANDLERS ----------
        $container[self::GET_TRIAL_WINNER_QUERY_HANDLER] =
            function (): Application\GetTrialWinnerQueryHandler {
                return new Application\GetTrialWinnerQueryHandler();
            };
        $container[self::GET_MINIMUM_ROLE_TO_WIN_THE_TRIAL_QUERY_HANDLER] =
            function (): Application\GetMinimumRoleToWinTheTrialQueryHandler {
                return new Application\GetMinimumRoleToWinTheTrialQueryHandler();
            };

        return new \Pimple\Psr11\Container($container);
    }
}
