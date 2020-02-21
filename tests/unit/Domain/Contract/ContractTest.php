<?php
declare(strict_types=1);

namespace LobbyWars\Domain\Contract;

use LobbyWars\Domain\Role\King;
use LobbyWars\Domain\Role\Notary;
use LobbyWars\Domain\Role\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Since;
use PHPUnit\Framework\TestCase;

class ContractTest extends TestCase
{
    public function testGivenEmptyContractWhenGettingPointsShouldReturnZero(): void
    {
        $signList = [];

        $sut = new Contract('id', $signList);

        $this->assertEquals(0, $sut->getPoints());
    }

    public function testGivenOneKingSignWhenGettingPointsShouldReturnTheKingPoints(): void
    {
        $role = new King();
        $signList = [new Sign($role)];

        $sut = new Contract('id', $signList);

        $this->assertEquals($role->getPoints(), $sut->getPoints());
    }

    public function testGivenOneNotarySignWhenGettingPointsShouldReturnTheNotaryPoints(): void
    {
        $role = new Notary();
        $signList = [new Sign($role)];

        $sut = new Contract('id', $signList);

        $this->assertEquals($role->getPoints(), $sut->getPoints());
    }

    public function testGivenOneValidatorSignWhenGettingPointsShouldReturnTheValidatorPoints(): void
    {
        $role = new Validator();
        $signList = [new Sign($role)];

        $sut = new Contract('id', $signList);

        $this->assertEquals($role->getPoints(), $sut->getPoints());
    }

    public function testGivenAKingSignAndAValidatorSignWhenGettingPointsShouldNotSumTheValidatorPoints(): void
    {
        $king = new King();
        $validator = new Validator();
        $signList = [new Sign($king), new Sign($validator)];

        $sut = new Contract('id', $signList);

        $totalPoints = 0;
        /** @var Sign $sign */
        foreach ($signList as $sign) {
            $totalPoints += $sign->getRole()->getPoints();
        }

        $this->assertEquals($totalPoints - $validator->getPoints(), $sut->getPoints());
    }

    public function testGivenOneBlankSignWhenCreatingTheContractShouldNotFail(): void
    {
        $signList = [new Sign(null)];

        $sut = new Contract('id', $signList);

        $this->assertEquals(0, $sut->getPoints());
    }

    public function testGivenMoreBlankSignsThanTheLimitWhenCreatingTheContractShouldThro(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $signList = [new Sign(null), new Sign(null)];

        new Contract('id', $signList);
    }
}
