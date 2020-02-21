<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Contract;

use LobbyWars\Domain\Role;

class Contract
{
    const MAX_BLANK_SIGNS = 1;

    /**
     * @var string
     */
    private $id;
    /**
     * @var Sign[]
     */
    private $signList = [];
    /**
     * @var bool
     */
    private $hasKingSigned = false;
    /**
     * @var int
     * */
    private $numOfBlankSigns = 0;

    public function __construct(string $id, array $signList)
    {
        $this->id = $id;
        foreach ($signList as $sign){
            $this->addSign($sign);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSignList(): array
    {
        return $this->signList;
    }

    public function hasKingSigned(): bool
    {
        return $this->hasKingSigned;
    }

    public function getNumOfBlankSigns(): int
    {
        return $this->numOfBlankSigns;
    }

    private function addSign(Sign $sign): void
    {
        $this->signList[] = $sign;

        if (null === $sign->getRole()) {
            $this->numOfBlankSigns++;
            if ($this->numOfBlankSigns > self::MAX_BLANK_SIGNS) {
                throw new \InvalidArgumentException('Max number of blank signs reached');
            }
        } elseif (Role\King::NAME === $sign->getRole()->getName()) {
            $this->hasKingSigned = true;
        }
    }

    public function getPoints(): int
    {
        $points = 0;
        foreach ($this->signList as $sign) {
            if ($this->shouldAddSignPoints($sign)) {
                $points += $sign->getPoints();
            }
        }

        return $points;
    }

    private function shouldAddSignPoints(Sign $sign): bool
    {
        return !$this->isBlankSing($sign) && !$this->hasKingValidatorException($sign);
    }

    private function isBlankSing(Sign $sign): bool
    {
        return null === $sign->getRole();
    }

    private function hasKingValidatorException(Sign $sign): bool
    {
        return $this->hasKingSigned() && Role\Validator::NAME === $sign->getRole()->getName();
    }
}
