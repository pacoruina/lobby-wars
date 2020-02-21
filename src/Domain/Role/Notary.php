<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Role;

class Notary implements Role
{
    const POINTS = 2;
    const NAME = 'Notary';

    public function getPoints(): int
    {
        return self::POINTS;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
