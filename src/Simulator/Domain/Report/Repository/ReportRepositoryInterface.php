<?php

namespace App\Simulator\Domain\Report\Repository;

use App\Simulator\Domain\Report\Model\Report;

interface ReportRepositoryInterface
{
    public function findOneByName(string $name): ?Report;

    public function findByBuildingAndDate(string $buildingName, string $date): ?array;

    public function save(Report $report): void;

    public function saveCollection(array $reports): void;

    public function saveCollectionByElevator(array $reportsByElevator): void;
}
