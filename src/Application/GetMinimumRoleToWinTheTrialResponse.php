<?php
declare(strict_types=1);

namespace LobbyWars\Application;

use LobbyWars\Domain\Role\Role;

class GetMinimumRoleToWinTheTrialResponse
{
    /**
     * @var null|Role
     */
    private $role;

    public function __construct(?Role $role)
    {
        $this->role = $role;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }
}
