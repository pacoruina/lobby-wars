<?php
declare(strict_types=1);

namespace LobbyWars\Application;

class GetTrialWinnerResponse
{
    /**
     * @var string
     */
    private $winnerId;

    public function __construct(string $winnerId)
    {
        $this->winnerId = $winnerId;
    }

    public function getWinnerId(): string
    {
        return $this->winnerId;
    }
}
