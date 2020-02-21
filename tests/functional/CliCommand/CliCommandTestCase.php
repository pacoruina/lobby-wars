<?php
declare(strict_types=1);

namespace LobbyWars\Tests\Functional\CliCommand;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console;
use LobbyWars\Infrastructure\Provider\DependenciesProvider;

abstract class CliCommandTestCase extends TestCase
{
    protected function runCommand(array $argv): array
    {
        $input = new Console\Input\ArgvInput($argv);
        $output = new Console\Output\BufferedOutput();

        $dependencies = new DependenciesProvider();
        $container = $dependencies->provide();
        // TODO: Mock here all the infrastructure (no need right now, there's none)

        $consoleApp = new Console\Application();
        $consoleApp->add($container->get(DependenciesProvider::PLAY_TRIAL_COMMAND));
        $consoleApp->add($container->get(DependenciesProvider::STRATEGY_TRIAL_COMMAND));
        $consoleApp->setAutoExit(false);
        $exitCode = $consoleApp->run($input, $output);

        return [$exitCode, $output];
    }
}
