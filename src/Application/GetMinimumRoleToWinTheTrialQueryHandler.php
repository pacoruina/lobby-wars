<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Contract\Contract;
use LobbyWars\Domain\Contract\Sign;
use LobbyWars\Domain\Role;

class GetMinimumRoleToWinTheTrialQueryHandler
{
    public function __invoke(GetMinimumRoleToWinTheTrialQuery $query): GetMinimumRoleToWinTheTrialResponse
    {
        if ($query->getMyContract()->getNumOfBlankSigns() === 0) {
            throw new \InvalidArgumentException('My contract should have one blank sign');
        }

        if ($query->getOppositionContract()->getNumOfBlankSigns() > 0) {
            throw new \InvalidArgumentException('Opposition contract is not completely know');
        }

        $rolesByPoints = [new Role\Validator(), new Role\Notary(), new Role\King()];
        foreach ($rolesByPoints as $role) {
            if ($this->checkIfSigningRoleWinsTheTrial($role, $query->getMyContract(), $query->getOppositionContract())) {
                return new GetMinimumRoleToWinTheTrialResponse($role);
            }
        }

        return new GetMinimumRoleToWinTheTrialResponse(null);
    }

    private function checkIfSigningRoleWinsTheTrial(Role\Role $role, Contract $myContract, Contract $oppositionContract): bool
    {
        $contract = new Contract($myContract->getId(), array_merge($myContract->getSignList(), [new Sign($role)]));

        return $contract->getPoints() > $oppositionContract->getPoints();
    }
}
