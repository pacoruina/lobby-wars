<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Contract\Contract;

class GetMinimumRoleToWinTheTrialQuery
{
    /**
     * @var Contract
     */
    private $myContract;
    /**
     * @var Contract
     */
    private $oppositionContract;

    public function __construct(Contract $myContract, Contract $oppositionContract)
    {
        $this->myContract = $myContract;
        $this->oppositionContract = $oppositionContract;
    }

    public function getMyContract(): Contract
    {
        return $this->myContract;
    }

    public function getOppositionContract(): Contract
    {
        return $this->oppositionContract;
    }
}
