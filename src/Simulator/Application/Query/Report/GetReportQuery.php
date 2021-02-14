<?php

declare(strict_types=1);

namespace App\Simulator\Application\Query\Report;

final class GetReportQuery
{
    private \DateTime $date;
    private string $buildingName;

    public function __construct(\DateTime $date, string $buildingName)
    {
        $this->date = $date;
        $this->buildingName = $buildingName;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getBuildingName(): string
    {
        return $this->buildingName;
    }
}

