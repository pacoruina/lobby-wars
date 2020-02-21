<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Contract\Contract;

class GetTrialWinnerQuery
{
    /**
     * @var Contract
     */
    private $plaintiffContract;
    /**
     * @var Contract
     */
    private $defendantContract;

    public function __construct(Contract $plaintiffContract, Contract $defendantContract)
    {
        $this->plaintiffContract = $plaintiffContract;
        $this->defendantContract = $defendantContract;
    }

    public function getPlaintiffContract(): Contract
    {
        return $this->plaintiffContract;
    }

    public function getDefendantContract(): Contract
    {
        return $this->defendantContract;
    }
}
