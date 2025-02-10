<?php

namespace App\Contracts;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

interface OrganizationRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Organization;
    public function getByBuilding(int $buildingId): Collection;
    public function getByActivity(int $activityId): Collection;
    public function searchByName(string $query): Collection;
    public function getByRadius(float $latitude, float $longitude, float $radius): Collection;
}