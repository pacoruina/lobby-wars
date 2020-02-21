<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Contract\Contract;
use LobbyWars\Domain\Contract\Sign;
use LobbyWars\Domain\Role\King;
use LobbyWars\Domain\Role\Role;
use LobbyWars\Domain\Role\Validator;
use PHPUnit\Framework\TestCase;

class GetMinimumRoleToWinTheTrialQueryHandlerTest extends TestCase
{
    /** @var GetMinimumRoleToWinTheTrialQueryHandler */
    private $sut;

    protected function setUp()
    {
        $this->sut = new GetMinimumRoleToWinTheTrialQueryHandler();
    }

    public function testGivenMyContractWithoutAnyBlankSignWhenGettingMinimumRoleToWinTheTrialShouldThrowAnError()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('My contract should have one blank sign');

        $myContract = new Contract('my', [new Sign(new Validator())]);
        $oppositionContract = new Contract('opposition', [new Sign(null)]);

        $query = new GetMinimumRoleToWinTheTrialQuery($myContract, $oppositionContract);

        $this->sut->__invoke($query);
    }

    public function testGivenOppositionContractWithBlankSignWhenGettingMinimumRoleToWinTheTrialShouldThrowAnError()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Opposition contract is not completely know');

        $myContract = new Contract('my', [new Sign(null)]);
        $oppositionContract = new Contract('opposition', [new Sign(null)]);

        $query = new GetMinimumRoleToWinTheTrialQuery($myContract, $oppositionContract);

        $this->sut->__invoke($query);
    }

    public function testGivenValidContractsWhenGettingMinimumRoleToWinTheTrialShouldReturnARole()
    {
        $myContract = new Contract('my', [new Sign(null)]);
        $oppositionContract = new Contract('opposition', [new Sign(new Validator())]);

        $query = new GetMinimumRoleToWinTheTrialQuery($myContract, $oppositionContract);

        $response = $this->sut->__invoke($query);

        $this->assertInstanceOf(Role::class, $response->getRole());
    }

    public function testGivenContractCannotBeWonWhenGettingMinimumRoleToWinTheTrialShouldReturnNoRole()
    {
        $myContract = new Contract('my', [new Sign(null)]);
        $oppositionContract = new Contract('opposition', [new Sign(new King())]);

        $query = new GetMinimumRoleToWinTheTrialQuery($myContract, $oppositionContract);

        $response = $this->sut->__invoke($query);

        $this->assertNull($response->getRole());
    }
}
