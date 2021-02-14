<?php

namespace App\Simulator\Domain\Sequence\Repository;

use App\Simulator\Domain\Sequence\Model\Sequence;

interface SequenceRepositoryInterface
{
    public function findByBuildingNameAndDay(string $name, string $date): ?array;

    public function save(Sequence $sequence): void;
}
