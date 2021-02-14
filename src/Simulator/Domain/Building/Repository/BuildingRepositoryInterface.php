<?php

namespace App\Simulator\Domain\Building\Repository;

use App\Simulator\Domain\Building\Model\Building;

interface BuildingRepositoryInterface
{
    public function findOneByName(string $name): ?Building;

    public function save(Building $building): void;
}
