<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Contract;

use LobbyWars\Domain\Role\Role;

class Sign
{
    /**
     * @var Role|null
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

    public function getPoints(): int
    {
        return (null !== $this->role) ? $this->getRole()->getPoints() : 0;
    }
}
