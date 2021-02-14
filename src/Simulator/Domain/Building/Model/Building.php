<?php

namespace App\Simulator\Domain\Building\Model;

use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Building
{
    private string $id;
    private \DateTime $creationDate;
    private string $name;
    private int $numFloors;
    private Collection $elevators;

    /**
     * Building constructor.
     * @param string $name
     * @param int $numFloors
     */
    private function __construct(string $name, int $numFloors)
    {
        $this->setId(Uuid::uuid4());
        $this->setCreationDate(new \DateTime());
        $this->setName($name);
        $this->setNumFloors($numFloors);
    }

    /**
     * @param string $name
     * @param int $numFloors
     * @return Building
     */
    public static function create(string $name, int $numFloors): Building
    {
        return new static($name, $numFloors);
    }

    private function assertIsBuildingNameValid($name): void
    {
        // ... Validates a name
        // throw exception if not
    }

    /**
     * @param string $id
     */
    private function setId(string $id): void
    {
        $this->id = $id;
    }

        /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
    private function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
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
        $this->assertIsBuildingNameValid($name);
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getElevators(): Collection
    {
        return $this->elevators;
    }

    /**
     * @param Collection $elevators
     */
    public function setElevators(Collection $elevators): void
    {
        $this->elevators = $elevators;
    }

    /**
     * @return int
     */
    public function getNumFloors(): int
    {
        return $this->numFloors;
    }

    /**
     * @param int $numFloors
     */
    public function setNumFloors(int $numFloors): void
    {
        $this->numFloors = $numFloors;
    }
}
