<?php

declare(strict_types=1);

namespace App\Simulator\Application\Query\Report;

use App\Simulator\Application\Query\Report\DTO\ReportDTO;
use App\Simulator\Domain\Report\Repository\ReportRepositoryInterface;

final class GetReportQueryHandler
{
    private ReportRepositoryInterface $reportRepository;

    public function __construct(
        ReportRepositoryInterface $reportRepository
    ) {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @param GetReportQuery $query
     * @return array
     */
    public function __invoke(GetReportQuery $query): array
    {
        $date = $query->getDate()->format('Y-m-d');
        $reports = $this->reportRepository->findByBuildingAndDate($query->getBuildingName(), $date);

        $reportResults = [];
        foreach ($reports as $report) {
            $reportResults[] = ReportDTO::fromEntity($report);
        }

        return $reportResults;
    }
}
