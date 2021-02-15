<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Simulator;

use App\Simulator\Domain\Building\Repository\BuildingRepositoryInterface;
use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Elevator\Repository\ElevatorRepositoryInterface;
use App\Simulator\Domain\Sequence\Model\Sequence;
use App\Simulator\Domain\Sequence\Repository\SequenceRepositoryInterface;
use Assert\Assertion;
use Assert\AssertionFailedException;

final class SimulatorCommandHandler
{
    private SequenceRepositoryInterface $sequenceRepository;
    private BuildingRepositoryInterface $buildingRepository;
    private ElevatorRepositoryInterface $elevatorRepository;

    public function __construct(
        SequenceRepositoryInterface $sequenceRepository,
        BuildingRepositoryInterface $buildingRepository,
        ElevatorRepositoryInterface $elevatorRepository
    ) {
        $this->sequenceRepository = $sequenceRepository;
        $this->buildingRepository = $buildingRepository;
        $this->elevatorRepository = $elevatorRepository;
    }

    /**
     * @param SimulatorCommand $command
     * @throws AssertionFailedException
     */
    public function __invoke(SimulatorCommand $command): void
    {
        $requests = $command->getRequest();
        $building = $this->buildingRepository->findOneByName($command->getBuildingName());
        if (empty($building)) {
            return;
        }

        $sequences = $elevators = [];
        foreach ($requests as $request) {

            $elevatorsAvailable = [];
            /** @var Elevator $elevator */
            foreach ($building->getElevators() as $elevator) {
                if (!$elevator->isBusy()) {
                    $elevatorsAvailable[] = $elevator;
                }
            }

            if (empty($elevatorsAvailable)) {
                continue;
            }

            $elevator = $elevatorsAvailable[array_rand($elevatorsAvailable, 1)];

            Assertion::keyExists($request, 'from');
            Assertion::keyExists($request, 'to');
            Assertion::keyExists($request, 'hour');
            Assertion::keyExists($request, 'minutes');
            Assertion::between($request['from'], 0, $building->getNumFloors() - 1);
            Assertion::between($request['to'], 0, $building->getNumFloors() - 1);

            // Fake busy elevator
            $elevator->setBusy(true);

            $now = new \DateTime();
            $now->setTime($request['hour'], $request['minutes']);

            $sequences[] = Sequence::create($now, $elevator->getCurrentFloor(), $request['from'], $request['to'], $elevator);
            
            // Fake available elevator again
            $elevator->setBusy(false);
            $elevator->setCurrentFloor($request['to']);
            $elevators[] = $elevator;
        }

        $this->sequenceRepository->saveCollection($sequences);
        $this->elevatorRepository->saveCollection($elevators);
    }
}
