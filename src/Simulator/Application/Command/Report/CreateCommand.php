<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Report;

final class CreateCommand
{
    private \DateTime $day;
    private string $buildingName;

    public function __construct(\DateTime $day, string $buildingName)
    {
        $this->day = $day;
        $this->buildingName = $buildingName;
    }

    public function getDay(): \DateTime
    {
        return $this->day;
    }

    public function getBuildingName(): string
    {
        return $this->buildingName;
    }
}
