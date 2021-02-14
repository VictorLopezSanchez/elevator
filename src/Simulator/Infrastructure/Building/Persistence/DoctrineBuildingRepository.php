<?php

declare(strict_types=1);

namespace App\Simulator\Infrastructure\Building\Persistence;

use App\Simulator\Domain\Building\Model\Building;
use App\Simulator\Domain\Building\Repository\BuildingRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineBuildingRepository implements BuildingRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Building $building): void
    {
        $this->em->persist($building);
        $this->em->flush();
    }

    public function findOneByName(string $name): ?Building
    {
        return $this->em->createQueryBuilder()
            ->select('b')
            ->from(Building::class, 'b')
            ->where('b.name = :name')
            ->setParameters(['name' => $name])
            ->getQuery()->getOneOrNullResult();
    }
}
