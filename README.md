# lobby-wars

* [Exercise Description](#Exercise Description)
* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
* [Testing](#testing)
* [Where to find the code](#Where to find the code)

## Exercise Description

**Lobby wars**

We are in the era of "lawsuits", everyone wants to go to court with their lawyer Saul and try to get a lot of dollars as if they were raining over Manhattan

The laws have changed much lately and governments have been digitized.

The city council maintains a registry of legal signatures of each party involved in the contracts that are made.

During a trial the justice only verifies the signatures of the parties involved in the contract to decide who wins. For that, they assign points to the different firms depending on their signers roles.

For example, if the plaintiff has a contract that is signed by a ** notary ** he gets 2 points, if the defendant has in the contract the signature of only a ** validator ** he gets only 1 point, so the plaintiff party wins the trial.

We want you to automate this process, given a contract with your 2 parties involved and their signatures and indicate which one wins the test

**Roles**

K - King - 5 points N - Notary - 2 points V - Validator - 1 point

Keep in mind that when a King signs, the signatures of the validators on his part have no value.

**First phase**

Make a program that has a contract in the  KN  vs  NNV  format, and define which party wins the trial?
    
**Second stage**

Sometimes the contract does not have all the signs, so we represent it using the  # character. Taking into account that only one signature per part can be empty to be valid, determine which is the minimum function necessary to win the trial given a contract with the signatures of the known opposition party.

For example, given  N # V  vs NVV  should return N


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
