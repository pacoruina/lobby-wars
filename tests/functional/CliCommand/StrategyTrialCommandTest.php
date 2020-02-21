<?php
declare(strict_types=1);

namespace LobbyWars\Tests\Functional\CliCommand;

use LobbyWars\Domain\Role\King;
use LobbyWars\Domain\Role\Notary;
use LobbyWars\Domain\Role\Validator;
use LobbyWars\Infrastructure\CliCommand\StrategyTrialCommand;

class StrategyTrialCommandTest extends CliCommandTestCase
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    public function testGivenNoArgumentsWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $argument = null;

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $argument]);

        $this->assertEquals(self::ERROR_CODE, $exitCode);
        $this->assertStringStartsWith('Not enough arguments', trim($output->fetch()));
    }

    public function testGivenInvalidNumberOfArgumentsWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $myInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput]);

        $this->assertEquals(self::ERROR_CODE, $exitCode);
        $this->assertStringStartsWith('Not enough arguments', trim($output->fetch()));
    }

    public function testGivenInvalidArgumentsWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $myInput = 'invalid';
        $oppositionInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput, $oppositionInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('Invalid role input', trim($output->fetch()));
    }

    public function testGivenTooMuchBlankSingsWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $myInput = '##';
        $oppositionInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput, $oppositionInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('Max number of blank signs reached', trim($output->fetch()));
    }

    public function testGivenNoBlankSingOnMyContractWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $myInput = 'N';
        $oppositionInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput, $oppositionInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('My contract should have one blank sign', trim($output->fetch()));
    }

    public function testGivenBlankSingOnOppositionContractWhenPlanningTrialStrategyShouldSuccessWithAWarningMessage()
    {
        $myInput = '#';
        $oppositionInput = '#';

        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput, $oppositionInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('Opposition contract is not completely know', trim($output->fetch()));
    }


    /**
     * @dataProvider getValidInputsAndExpectedOutput()
     * @param string $myInput
     * @param string $oppositionInput
     * @param string $expectedOutput
     */
    public function testGivenValidInputsWhenPlanningTrialStrategyShouldSuccessWithAMessage(
        string $myInput,
        string $oppositionInput,
        string $expectedOutput
    ) {
        list($exitCode, $output) = $this->runCommand(['bin/console', StrategyTrialCommand::CLI_COMMAND_NAME, $myInput, $oppositionInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith($expectedOutput, trim($output->fetch()));
    }

    public function getValidInputsAndExpectedOutput()
    {
        return [
            ['#', 'V', Notary::NAME],
            ['#', 'N', King::NAME],
            ['#', 'NN', King::NAME],
            ['#', 'VVVV', King::NAME],
            ['#', 'K', StrategyTrialCommand::NO_WAY_MESSAGE],
            ['V#', 'K', StrategyTrialCommand::NO_WAY_MESSAGE],
            ['V#', 'V', Validator::NAME],
            ['N#', 'KK', StrategyTrialCommand::NO_WAY_MESSAGE],
            ['N#V', 'NVV', Notary::NAME],
        ];
    }
}
