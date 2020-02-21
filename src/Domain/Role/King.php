<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Role;

class King implements Role
{
    const POINTS = 5;
    const NAME = 'King';

    public function getPoints(): int
    {
        return self::POINTS;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
