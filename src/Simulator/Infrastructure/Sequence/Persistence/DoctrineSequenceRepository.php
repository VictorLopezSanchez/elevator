<?php

declare(strict_types=1);

namespace App\Simulator\Infrastructure\Sequence\Persistence;

use App\Simulator\Domain\Building\Model\Building;
use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Sequence\Model\Sequence;
use App\Simulator\Domain\Sequence\Repository\SequenceRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineSequenceRepository implements SequenceRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Sequence $sequence): void
    {
        $this->em->persist($sequence);
        $this->em->flush();
    }

    public function saveCollection(array $sequences): void
    {
        foreach ($sequences as $sequence) {
            $this->em->persist($sequence);
        }

        $this->em->flush();
    }

    public function findByBuildingNameAndDay(string $name, string $date): ?array
    {
        return $this->em->createQueryBuilder()
            ->select('s')
            ->from(Sequence::class, 's')
            ->join(Elevator::class, 'e', 'WITH', 'e.id = s.elevator')
            ->join(Building::class, 'b', 'WITH', 'b.id = e.building')
            ->where('s.creationDate > :date_init')
            ->andWhere('s.creationDate < :date_end')
            ->andWhere('b.name = :name')
            ->groupBy('s.id')
            ->orderBy('s.creationDate', 'ASC')
            ->setParameters([
                'name' => $name,
                'date_init' => $date . ' 00:00:00',
                'date_end' => $date . ' 23:59:59'
            ])
            ->getQuery()->getResult();
    }
}
