<?php

declare(strict_types=1);

namespace App\Simulator\Application\Command\Building;

use App\Simulator\Domain\Building\Model\Building;
use App\Simulator\Domain\Building\Repository\BuildingRepositoryInterface;

final class CreateCommandHandler
{
    private BuildingRepositoryInterface $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository) {
        $this->buildingRepository = $buildingRepository;
    }

    public function __invoke(CreateCommand $command): void
    {
        $building = Building::create(
            $command->getName(),
            $command->getNumFloors()
        );

        $this->buildingRepository->save($building);
    }
}
