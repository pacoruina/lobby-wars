<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Role;

interface Role
{
    public function getPoints(): int;
    public function getName(): string;
}
