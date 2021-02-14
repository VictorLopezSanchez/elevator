<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Simulator;

final class SimulatorCommand
{
    private array $request;
    private string $buildingName;

    public function __construct(string $buildingName, array $request)
    {
        $this->request = $request;
        $this->buildingName = $buildingName;
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function getBuildingName(): string
    {
        return $this->buildingName;
    }
}
