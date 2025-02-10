<?php

namespace App\Services;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationService
{
    /**
     * @var OrganizationRepositoryInterface
     */
    private OrganizationRepositoryInterface $organizationRepository;

    /**
     * @param OrganizationRepositoryInterface $organizationRepository
     */
    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @return Collection
     */
    public function getAllOrganizations(): Collection
    {
        return $this->organizationRepository->getAll();
    }

    /**
     * @param int $id
     * @return Organization|null
     */
    public function getOrganizationById(int $id): ?Organization
    {
        return $this->organizationRepository->getById($id);
    }

    /**
     * @param int $buildingId
     * @return Collection
     */
    public function getOrganizationsByBuilding(int $buildingId): Collection
    {
        return $this->organizationRepository->getByBuilding($buildingId);
    }

    /**
     * @param int $activityId
     * @return Collection
     */
    public function getOrganizationsByActivity(int $activityId): Collection
    {
        return $this->organizationRepository->getByActivity($activityId);
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function searchOrganizations(string $query): Collection
    {
        return $this->organizationRepository->searchByName($query);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     * @return Collection
     */
    public function getOrganizationsByRadius(float $latitude, float $longitude, float $radius): Collection
    {
        return $this->organizationRepository->getByRadius($latitude, $longitude, $radius);
    }
}
