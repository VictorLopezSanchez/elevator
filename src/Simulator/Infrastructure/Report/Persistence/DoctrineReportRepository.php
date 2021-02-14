<?php

declare(strict_types=1);

namespace App\Simulator\Infrastructure\Report\Persistence;

use App\Simulator\Domain\Building\Model\Building;
use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Report\Model\Report;
use App\Simulator\Domain\Report\Repository\ReportRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineReportRepository implements ReportRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Report $report): void
    {
        $this->em->persist($report);
        $this->em->flush();
    }

    public function saveCollection(array $reports): void
    {
        foreach ($reports as $report) {
            $this->em->persist($report);
        }

        $this->em->flush();
    }

    public function saveCollectionByElevator(array $reportsByElevator): void
    {
        foreach ($reportsByElevator as $reportByDay) {
            foreach ($reportByDay as $report) {
                $this->em->persist($report);
            }
        }

        $this->em->flush();
    }

    public function findOneByName(string $name): ?Report
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from(Report::class, 'e')
            ->where('e.name = :name')
            ->setParameters(['name' => $name])
            ->getQuery()->getOneOrNullResult();
    }

    public function findByBuildingAndDate(string $buildingName, string $date): ?array
    {
        return $this->em->createQueryBuilder()
            ->select('r')
            ->from(Report::class, 'r')
            ->join(Building::class, 'b', 'WITH', 'b.id = r.buildingId')
            ->where('b.name = :name')
            ->andWhere('r.date > :date_init')
            ->andWhere('r.date < :date_end')
            ->groupBy('r.id')
            ->orderBy('r.date')
            ->setParameters([
                'name' => $buildingName,
                'date_init' => $date . ' 00:00:00',
                'date_end' => $date . ' 23:59:59'
            ])
            ->getQuery()->getResult();
    }
}
