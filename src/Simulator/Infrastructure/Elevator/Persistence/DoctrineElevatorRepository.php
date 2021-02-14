<?php

declare(strict_types=1);

namespace App\Simulator\Infrastructure\Elevator\Persistence;

use App\Simulator\Domain\Building\Model\Building;
use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Elevator\Repository\ElevatorRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineElevatorRepository implements ElevatorRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Elevator $elevator): void
    {
        $this->em->persist($elevator);
        $this->em->flush();
    }

    public function findByBuildingName(string $name): ?array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from(Elevator::class, 'e')
            ->join(Building::class, 'b')
            ->where('b.name = :name')
            ->setParameters(['name' => $name])
            ->getQuery()->getResult();
    }
}
