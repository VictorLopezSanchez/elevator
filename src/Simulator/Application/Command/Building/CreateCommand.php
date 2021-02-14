<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Building;

final class CreateCommand
{
    private string $name;
    private int $numFloors;

    public function __construct(string $name, int $numFloors)
    {
        $this->name = $name;
        $this->numFloors = $numFloors;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumFloors(): int
    {
        return $this->numFloors;
    }
}
