<?php

namespace App\Simulator\Domain\Elevator\Repository;

use App\Simulator\Domain\Elevator\Model\Elevator;

interface ElevatorRepositoryInterface
{
    public function findByBuildingName(string $name): ?array;

    public function save(Elevator $elevator): void;
}
