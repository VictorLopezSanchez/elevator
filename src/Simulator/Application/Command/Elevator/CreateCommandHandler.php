<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Elevator;



use App\Simulator\Domain\Building\Repository\BuildingRepositoryInterface;
use App\Simulator\Domain\Elevator\Model\Elevator;
use App\Simulator\Domain\Elevator\Repository\ElevatorRepositoryInterface;

final class CreateCommandHandler
{
    private ElevatorRepositoryInterface $elevatorRepository;
    private BuildingRepositoryInterface $buildingRepository;

    public function __construct(
        ElevatorRepositoryInterface $elevatorRepository,
        BuildingRepositoryInterface $buildingRepository
    ) {
        $this->elevatorRepository = $elevatorRepository;
        $this->buildingRepository = $buildingRepository;
    }

    public function __invoke(CreateCommand $command): void
    {
        $building = $this->buildingRepository->findOneByName($command->getBuildingName());
        if (empty($building)) {
            return;
        }

        $elevator = Elevator::create($command->getName(), $command->getCurrentFloor(), $building);
        $this->elevatorRepository->save($elevator);
    }
}
