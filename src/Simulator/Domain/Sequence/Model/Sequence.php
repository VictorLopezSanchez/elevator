<?php

namespace App\Simulator\Domain\Sequence\Model;

use App\Simulator\Domain\Elevator\Model\Elevator;
use Ramsey\Uuid\Uuid;

class Sequence
{
    private string $id;
    private \DateTime $creationDate;
    private int $fromFloor;
    private int $fromRequest;
    private int $toFloor;
    private Elevator $elevator;

    /**
     * Sequence constructor.
     * @param \DateTime $creationDate
     * @param int $fromFloor
     * @param int $fromRequest
     * @param int $toFloor
     * @param Elevator $elevator
     */
    private function __construct(
        \DateTime $creationDate,
        int $fromFloor,
        int $fromRequest,
        int $toFloor,
        Elevator $elevator
    )
    {
        $this->setId(Uuid::uuid4());
        $this->setCreationDate($creationDate);
        $this->setFromFloor($fromFloor);
        $this->setFromRequest($fromRequest);
        $this->setToFloor($toFloor);
        $this->setElevator($elevator);
    }

    public static function create(
        \DateTime $creationDate,
        int $fromFloor,
        int $fromRequest,
        int $toFloor,
        Elevator $elevator
    ): Sequence
    {
        return new static(
            $creationDate,
            $fromFloor,
            $fromRequest,
            $toFloor,
            $elevator
        );
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
    private function setId(string $id): void
    {
        $this->id = $id;
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
     * @return Elevator
     */
    public function getElevator(): Elevator
    {
        return $this->elevator;
    }

    /**
     * @param Elevator $elevator
     */
    public function setElevator(Elevator $elevator): void
    {
        $this->elevator = $elevator;
    }

    /**
     * @return int
     */
    public function getFromFloor(): int
    {
        return $this->fromFloor;
    }

    /**
     * @param int $fromFloor
     */
    public function setFromFloor(int $fromFloor): void
    {
        $this->fromFloor = $fromFloor;
    }

    /**
     * @return int
     */
    public function getToFloor(): int
    {
        return $this->toFloor;
    }

    /**
     * @param int $toFloor
     */
    public function setToFloor(int $toFloor): void
    {
        $this->toFloor = $toFloor;
    }

    /**
     * @return int
     */
    public function getFromRequest(): int
    {
        return $this->fromRequest;
    }

    /**
     * @param int $fromRequest
     */
    public function setFromRequest(int $fromRequest): void
    {
        $this->fromRequest = $fromRequest;
    }
}
