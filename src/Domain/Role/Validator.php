<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Role;

class Validator implements Role
{
    const POINTS = 1;
    const NAME = 'Validator';

    public function getPoints(): int
    {
        return self::POINTS;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
