# lobby-wars

* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Testing](#testing)
* [Where to find the code](#Where to find the code)

## Requirements

This application requires PHP 7.1; using the latest version of PHP is highly recommended.

## Installation

In order to install the project dependencies, you'll need composer on your system, follow the instructions on [getcomposer.org](https://getcomposer.org) to install it.

Then, on the root project directory, the easiest is then to simply call:
```sh
composer install
```

## Usage

To see the available commands:  
```sh
./bin/console
```
To execute the trial:play command:  
```sh
./bin/console trial:play <plaintiff> <defendant>
```
To execute the trial:strategy command:  
```sh
./bin/console trial:strategy <myContract> <oppositionContract>
```

## Testing

To execute the all the test suite with coverage:  
```sh
./bin/phpunit
```
For a more verbose execution, you can use the --testdox option:
```
./bin/phpunit --testdox
```
And you can find the coverage output here, in different formats:
```
/build/logs
```

## Where to find the code:

**Dependencies (composer.json)**
* **"symfony/console"**: Allows you to create command-line commands.
* **"pimple/pimple"**: Pimple is a simple PHP Dependency Injection Container

**Console and Bootstraping:**
* lobby-wars/src/Infrastructure/UI/Console/console.php

**The cli-commands:**
* lobby-wars/src/Infrastructure/CliCommand/PlayTrialCommand.php
* lobby-wars/src/Infrastructure/CliCommand/StrategyTrialCommand.php

**The Application Layer:**
* **GetTrialWinnerQueryHandler Query-Handler**: 
    * Play the Trial with the provided contracts and return the id of who have more points (or tie id).
* **GetMinimumRoleToWinTheTrialQueryHandler Query-Handler**:
    * Given my Contract has a blank sign and opposition Contract is know, returns the minimum role that allow us to win, or non if winning it's not possible. 
