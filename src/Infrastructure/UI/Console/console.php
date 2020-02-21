#!/usr/bin/env php
<?php
if ('cli' !== php_sapi_name()) {
    die('This is only accessible through console.');
}

require_once __DIR__ . '/../../../../vendor/autoload.php';

use Symfony\Component\Console\Application;
use LobbyWars\Infrastructure\Provider\DependenciesProvider;

$application = new Application();

$dependencies = new DependenciesProvider();
$container = $dependencies->provide();

$application->add($container->get(DependenciesProvider::PLAY_TRIAL_COMMAND));
$application->add($container->get(DependenciesProvider::STRATEGY_TRIAL_COMMAND));

$application->run();