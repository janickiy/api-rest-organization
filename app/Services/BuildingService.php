<?php

namespace App\Services;

use App\Contracts\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BuildingService
{
    /**
     * @var BuildingRepositoryInterface
     */
    private BuildingRepositoryInterface $buildingRepository;

    public function __construct(BuildingRepositoryInterface $buildingRepository)
    {
        $this->buildingRepository = $buildingRepository;
    }

    /**
     * @return Collection
     */
    public function getAllBuildings(): Collection
    {
        return $this->buildingRepository->getAll();
    }
}
