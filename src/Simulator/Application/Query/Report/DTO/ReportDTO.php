<?php

declare(strict_types=1);

namespace App\Simulator\Application\Query\Report\DTO;

use App\Simulator\Domain\Report\Model\Report;

final class ReportDTO
{
    private string $id;
    private string $elevatorName;
    private string $buildingName;

    private int $currentFloor;
    private int $numTraveledFloors;
    private int $numTotalTraveledFloors;

    private \DateTime $executionDay;
    private \DateTime $createdAt;

    public static function fromEntity(Report $report): ReportDTO
    {
        $dto = new ReportDTO();
        $dto->setId($report->getId());
        $dto->setNumTraveledFloors($report->getNumTraveledFloors());
        $dto->setNumTotalTraveledFloors($report->getNumTotalTraveledFloors());
        $dto->setCurrentFloor($report->getCurrentFloor());
        $dto->setElevatorName($report->getElevatorId());
        $dto->setBuildingName($report->getBuildingId());
        $dto->setExecutionDay($report->getCreationDate());
        $dto->setCreatedAt($report->getDate());

        return $dto;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return ReportDTO
     */
    public static function fromQueryArray(array $data): ReportDTO
    {
        return new static();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getElevatorName(): string
    {
        return $this->elevatorName;
    }

    /**
     * @param string $elevatorName
     */
    public function setElevatorName(string $elevatorName): void
    {
        $this->elevatorName = $elevatorName;
    }

    /**
     * @return string
     */
    public function getBuildingName(): string
    {
        return $this->buildingName;
    }

    /**
     * @param string $buildingName
     */
    public function setBuildingName(string $buildingName): void
    {
        $this->buildingName = $buildingName;
    }

    /**
     * @return \DateTime
     */
    public function getExecutionDay(): \DateTime
    {
        return $this->executionDay;
    }

    /**
     * @param \DateTime $executionDay
     */
    public function setExecutionDay(\DateTime $executionDay): void
    {
        $this->executionDay = $executionDay;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getNumTraveledFloors(): int
    {
        return $this->numTraveledFloors;
    }

    /**
     * @param int $numTraveledFloors
     */
    public function setNumTraveledFloors(int $numTraveledFloors): void
    {
        $this->numTraveledFloors = $numTraveledFloors;
    }

    /**
     * @return int
     */
    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    /**
     * @param int $currentFloor
     */
    public function setCurrentFloor(int $currentFloor): void
    {
        $this->currentFloor = $currentFloor;
    }

    /**
     * @return int
     */
    public function getNumTotalTraveledFloors(): int
    {
        return $this->numTotalTraveledFloors;
    }

    /**
     * @param int $numTotalTraveledFloors
     */
    public function setNumTotalTraveledFloors(int $numTotalTraveledFloors): void
    {
        $this->numTotalTraveledFloors = $numTotalTraveledFloors;
    }
}
