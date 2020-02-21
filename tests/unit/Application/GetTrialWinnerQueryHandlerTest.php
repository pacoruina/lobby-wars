<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Contract\Contract;
use LobbyWars\Domain\Contract\Sign;
use LobbyWars\Domain\Role\Validator;
use PHPUnit\Framework\TestCase;

class GetTrialWinnerQueryHandlerTest extends TestCase
{
    /** @var GetTrialWinnerQueryHandler */
    private $sut;

    protected function setUp()
    {
        $this->sut = new GetTrialWinnerQueryHandler();
    }

    public function testGivenContractsWithSamePointsWhenGettingWinnerQueryShouldReturnTieTrial()
    {
        $plaintiffContract = new Contract('plaintiff', []);
        $defendantContract = new Contract('defendant', []);

        $query = new GetTrialWinnerQuery($plaintiffContract, $defendantContract);

        $response = $this->sut->__invoke($query);

        $this->assertEquals($this->sut::TIE_TRIAL, $response->getWinnerId());
    }

    public function testGivenPlaintiffContractHasMorePointsWhenGettingWinnerQueryShouldReturnThePlaintiffAsWinner()
    {
        $plaintiffContract = new Contract('plaintiff', [new Sign(new Validator())]);
        $defendantContract = new Contract('defendant', []);

        $query = new GetTrialWinnerQuery($plaintiffContract, $defendantContract);

        $response = $this->sut->__invoke($query);

        $this->assertEquals($plaintiffContract->getId(), $response->getWinnerId());
    }

    public function testGivenDefendantContractHasMorePointsWhenGettingWinnerQueryShouldReturnTheDefendantAsWinner()
    {
        $plaintiffContract = new Contract('plaintiff', []);
        $defendantContract = new Contract('defendant', [new Sign(new Validator())]);

        $query = new GetTrialWinnerQuery($plaintiffContract, $defendantContract);

        $response = $this->sut->__invoke($query);

        $this->assertEquals($defendantContract->getId(), $response->getWinnerId());
    }
}
