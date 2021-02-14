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

        foreach ($requests as $request) {
            $elevatorsAvailable = [];
            /** @var Elevator $elevator */
            foreach ($building->getElevators() as $elevator) {
                if (!$elevator->isBusy()) {
                    $elevatorsAvailable[] = $elevator;
                }
            }

            if (empty($elevatorsAvailable)) {
                // Este caso no se puede dar ya que la implementacion con Workers solo cogeria un nuevo Request
                // cuando este disponible (cuando haya terminado el proceso)
                continue;
            }

            // Cogemos uno random de los disponibles (con la cola de prioridad sería siguiendo la politica correspondiente)
            $elevator = $elevatorsAvailable[array_rand($elevatorsAvailable, 1)];

            Assertion::keyExists($request, 'from');
            Assertion::keyExists($request, 'to');
            Assertion::keyExists($request, 'hour');
            Assertion::keyExists($request, 'minutes');
            Assertion::between($request['from'], 0, $building->getNumFloors() - 1);
            Assertion::between($request['to'], 0, $building->getNumFloors() - 1);

            // Durante este proceso el ascensor estaría moviendose y ocupado y lo interpreto con esta variable.
            $elevator->setBusy(true);

            $now = new \DateTime();
            $now->setTime($request['hour'], $request['minutes']);

            // Aquí soy consciente que hay un N+1, no lo he mejorado ya que en un sistema real con colas
            // solo se ejecutaría una request a la vez y no existiría el foreach
            $sequence = Sequence::create($now, $elevator->getCurrentFloor(), $request['from'], $request['to'], $elevator);
            $this->sequenceRepository->save($sequence);

            $elevator->setCurrentFloor($request['to']);
            $this->elevatorRepository->save($elevator);
        }

        // Llegado a este punto asumimos que vuelven a estar disponibles.
        // Dado que deberian ser Workers esta es la manera de decir que ha terminado el proceso y
        // esta disponible para un nuevo Request.
        // Asumimos que para este ejemplo no llegaran mas de 3 requests a la vez.
        foreach ($building->getElevators() as $elevator) {
            if ($elevator->isBusy()) {
                $elevator->setBusy(false);
            }
        }
    }
}
