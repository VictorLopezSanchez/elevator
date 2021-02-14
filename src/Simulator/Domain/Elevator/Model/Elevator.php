<?php

namespace App\Simulator\Domain\Elevator\Model;

use App\Simulator\Domain\Building\Model\Building;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Elevator
{
    private string $id;
    private string $name;
    private bool $busy;
    private int $currentFloor;
    private Building $building;
    private Collection $sequences;
    private \DateTime $creationDate;

    /**
     * Elevator constructor.
     * @param string $name
     * @param int $currentFloor
     * @param Building $building
     */
    private function __construct(string $name, int $currentFloor, Building $building)
    {
        $this->setId(Uuid::uuid4());
        $this->setCreationDate(new \DateTime());
        $this->setBusy(false);
        $this->setName($name);
        $this->setCurrentFloor($currentFloor);
        $this->setBuilding($building);
    }

    public static function create(string $name, int $currentFloor, Building $building): Elevator
    {
        return new static($name, $currentFloor, $building);
    }

        /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface|string $id
     */
    private function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param \DateTime $creationDate
     */
    private function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Building
     */
    public function getBuilding(): Building
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding(Building $building): void
    {
        $this->building = $building;
    }

    /**
     * @return Collection
     */
    public function getSequences(): Collection
    {
        return $this->sequences;
    }

    /**
     * @param Collection $sequences
     */
    public function setSequences(Collection $sequences): void
    {
        $this->sequences = $sequences;
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
     * @return bool
     */
    public function isBusy(): bool
    {
        return $this->busy;
    }

    /**
     * @param bool busy
     */
    public function setBusy(bool $busy): void
    {
        $this->busy = $busy;
    }
}
