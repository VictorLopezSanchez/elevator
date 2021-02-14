<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Elevator;

final class CreateCommand
{
    private string $name;
    private int $currentFloor;
    private string $buildingName;

    public function __construct(string $name, int $currentFloor, string $buildingName)
    {
        $this->name = $name;
        $this->currentFloor = $currentFloor;
        $this->buildingName = $buildingName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    public function getBuildingName(): string
    {
        return $this->buildingName;
    }
}
