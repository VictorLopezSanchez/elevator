<?php

namespace App\Simulator\Domain\Report\Model;

use Ramsey\Uuid\Uuid;

class Report
{
    private string $id;
    private int $numTraveledFloors;
    private ?int $numTotalTraveledFloors;
    private ?int $currentFloor;
    private \DateTime $creationDate;
    private \DateTime $date;
    private string $elevatorId;
    private string $buildingId;

    /**
     * Report constructor.
     * @param string $elevatorId
     * @param string $buildingId
     * @param \DateTime $date
     */
    private function __construct(string $elevatorId, string $buildingId, \DateTime $date)
    {
        $this->setId(Uuid::uuid4());
        $this->setCreationDate(new \DateTime());
        $this->setNumTraveledFloors(0);
        $this->setNumTotalTraveledFloors(null);
        $this->setCurrentFloor(null);
        $this->setElevatorId($elevatorId);
        $this->setBuildingId($buildingId);
        $this->setDate($date);
    }

    public static function create(string $elevatorId, string $buildingId, \DateTime $date): Report
    {
        return new static($elevatorId, $buildingId, $date);
    }

    /**
     * @return \Ramsey\Uuid\UuidInterface|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        $this->id = $id;
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
     * @return int|null
     */
    public function getCurrentFloor(): ?int
    {
        return $this->currentFloor;
    }

    /**
     * @param int|null $currentFloor
     */
    public function setCurrentFloor(?int $currentFloor): void
    {
        $this->currentFloor = $currentFloor;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getElevatorId(): string
    {
        return $this->elevatorId;
    }

    /**
     * @param string $elevatorId
     */
    public function setElevatorId(string $elevatorId): void
    {
        $this->elevatorId = $elevatorId;
    }

    /**
     * @return string
     */
    public function getBuildingId(): string
    {
        return $this->buildingId;
    }

    /**
     * @param string $buildingId
     */
    public function setBuildingId(string $buildingId): void
    {
        $this->buildingId = $buildingId;
    }

    /**
     * @return int|null
     */
    public function getNumTotalTraveledFloors(): ?int
    {
        return $this->numTotalTraveledFloors;
    }

    /**
     * @param int|null $numTotalTraveledFloors
     */
    public function setNumTotalTraveledFloors(?int $numTotalTraveledFloors): void
    {
        $this->numTotalTraveledFloors = $numTotalTraveledFloors;
    }
}
