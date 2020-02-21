<?php
declare(strict_types=1);

namespace LobbyWars\Tests\Functional\CliCommand;

use LobbyWars\Infrastructure\CliCommand\PlayTrialCommand;

class PlayTrialCommandTest extends CliCommandTestCase
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    public function testGivenNoArgumentsWhenPlayingTrialShouldSuccessWithAWarningMessage()
    {
        $argument = null;

        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $argument]);

        $this->assertEquals(self::ERROR_CODE, $exitCode);
        $this->assertStringStartsWith('Not enough arguments', trim($output->fetch()));
    }

    public function testGivenInvalidNumberOfArgumentsWhenPlayingTrialShouldSuccessWithAWarningMessage()
    {
        $plaintiffInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $plaintiffInput]);

        $this->assertEquals(self::ERROR_CODE, $exitCode);
        $this->assertStringStartsWith('Not enough arguments', trim($output->fetch()));
    }

    public function testGivenInvalidArgumentsWhenPlayingTrialShouldSuccessWithAWarningMessage()
    {
        $plaintiffInput = 'invalid';
        $defendantInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $plaintiffInput, $defendantInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('Invalid role input', trim($output->fetch()));
    }

    public function testGivenTooMuchBlankSingsWhenPlayingTrialShouldSuccessWithAWarningMessage()
    {
        $plaintiffInput = '##';
        $defendantInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $plaintiffInput, $defendantInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('Max number of blank signs reached', trim($output->fetch()));
    }

    public function testGivenValidArgumentsWhenPlayingTrialShouldSuccessWithAMessage()
    {
        $plaintiffInput = 'K';
        $defendantInput = 'N';

        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $plaintiffInput, $defendantInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertTrue(is_string(trim($output->fetch())));
    }

    /**
     * @dataProvider getFirstPlayerAsWinner()
     * @param string $plaintiffInput
     * @param string $defendantInput
     */
    public function testGivenPlaintiffAsWinnerWhenPlayingTrialShouldSuccessWithAMessage(
        string $plaintiffInput,
        string $defendantInput
    ) {
        list($exitCode, $output) = $this->runCommand(['bin/console', PlayTrialCommand::CLI_COMMAND_NAME, $plaintiffInput, $defendantInput]);

        $this->assertEquals(self::SUCCESS_CODE, $exitCode);
        $this->assertStringStartsWith('plaintiff', trim($output->fetch()));
    }

    public function getFirstPlayerAsWinner()
    {
        return [
            ['V', '#'],
            ['N', '#'],
            ['K', '#'],

            ['N', 'V'],
            ['K', 'V'],
            ['VV', 'V'],
            ['VN', 'V'],
            ['VK', 'V'],

            ['K', 'N'],
            ['NV', 'N'],
            ['NN', 'N'],
            ['NK', 'N'],
            ['VVV', 'N'],

            ['KN', 'K'],
            ['KK', 'K'],
            ['VVVVVV', 'K'],
            ['NNN', 'K'],
        ];
    }
}
