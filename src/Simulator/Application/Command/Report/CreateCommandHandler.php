<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Report;

use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Elevator\Repository\ElevatorRepositoryInterface;
use App\Simulator\Domain\Report\Model\Report;
use App\Simulator\Domain\Report\Repository\ReportRepositoryInterface;
use App\Simulator\Domain\Sequence\Model\Sequence;
use App\Simulator\Domain\Sequence\Repository\SequenceRepositoryInterface;

final class CreateCommandHandler
{
    public const START_TIME = '09:00';
    public const END_TIME = '19:59';

    private SequenceRepositoryInterface $sequenceRepository;
    private ReportRepositoryInterface $reportRepository;
    private ElevatorRepositoryInterface $elevatorRepository;

    public function __construct(
        SequenceRepositoryInterface $sequenceRepository,
        ElevatorRepositoryInterface $elevatorRepository,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->sequenceRepository = $sequenceRepository;
        $this->elevatorRepository = $elevatorRepository;
        $this->reportRepository = $reportRepository;
    }

    public function __invoke(CreateCommand $command): void
    {
        $elevators = $this->elevatorRepository->findByBuildingName($command->getBuildingName());
        if (empty($elevators)) {
            return;
        }

        $date = $command->getDay()->format('Y-m-d');
        $sequences = $this->sequenceRepository->findByBuildingNameAndDay($command->getBuildingName(), $date);
        if (empty($sequences)) {
            return;
        }

        $elevatorsHistory = [];
        $reportByElevator = [];
        foreach ($elevators as $elevator) {
            $reportByElevator[$elevator->getId()] = $this->getReportByMinute($elevator, $date);
            $elevatorsHistory[$elevator->getId()] = [
                'initialFloor' => null,
                'numTotalTravelsFloor' => 0
            ];
        }

        /** @var Sequence $sequence */
        foreach ($sequences as $sequence) {
            $date = $sequence->getCreationDate()->format('H:i');
            $elevator = $sequence->getElevator()->getId();

            $toCallTravel = abs($sequence->getFromRequest() - $sequence->getFromFloor());
            $toFloorTravel = abs($sequence->getToFloor() - $sequence->getFromRequest());
            $numTraveledFloors = $toCallTravel + $toFloorTravel;

            if (is_null($elevatorsHistory[$elevator]['initialFloor'])) {
                $elevatorsHistory[$elevator]['initialFloor'] = $sequence->getFromFloor();
            }

            $elevatorsHistory[$elevator]['numTotalTravelsFloor'] += $numTraveledFloors;
            $reportByElevator[$elevator][$date]->setNumTotalTraveledFloors($elevatorsHistory[$elevator]['numTotalTravelsFloor']);
            $reportByElevator[$elevator][$date]->setNumTraveledFloors($numTraveledFloors);
            $reportByElevator[$elevator][$date]->setCurrentFloor($sequence->getToFloor());
        }

        foreach ($reportByElevator as $elevator => $reports) {
            $lastFloor = $elevatorsHistory[$elevator]['initialFloor'];
            $numTotalTraveledFloors = $elevatorsHistory[$elevator]['initialFloor'];
            foreach ($reports as $reportByHour) {
                if (is_null($reportByHour->getNumTotalTraveledFloors())) {
                    $reportByHour->setNumTotalTraveledFloors($numTotalTraveledFloors);
                } else {
                    $numTotalTraveledFloors = $reportByHour->getNumTotalTraveledFloors();
                }

                if (is_null($reportByHour->getCurrentFloor())) {
                    $reportByHour->setCurrentFloor($lastFloor);
                } else {
                    $lastFloor = $reportByHour->getCurrentFloor();
                }
            }
        }

        $this->reportRepository->saveCollectionByElevator($reportByElevator);
    }

    public function getReportByMinute(Elevator $elevator, string $date): array
    {
        $startTime  = new \DateTime($date . ' ' . self::START_TIME);
        $endTime    = new \DateTime($date . ' ' . self::END_TIME);
        $timeStep   = 1;
        $timeArray  = array();

        while($startTime <= $endTime)
        {
            $report = Report::create($elevator->getId(), $elevator->getBuilding()->getId(), clone $startTime);
            $timeArray[$startTime->format('H:i')] = $report;
            $startTime->add(new \DateInterval('PT'.$timeStep.'M'));
        }

        return $timeArray;
    }
}
