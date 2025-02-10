<?php

namespace App\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function getAll(): Collection
    {
        return Organization::all();
    }

    /**
     * @param int $id
     * @return Organization|null
     */
    public function getById(int $id): ?Organization
    {
        return Organization::find($id);
    }

    /**
     * @param int $buildingId
     * @return Collection
     */
    public function getByBuilding(int $buildingId): Collection
    {
        return Organization::where('building_id', $buildingId)->get();
    }

    /**
     * @param int $activityId
     * @return Collection
     */
    public function getByActivity(int $activityId): Collection
    {
        return Organization::whereHas('activities', function ($query) use ($activityId) {
            $query->where('activities.id', $activityId);
        })->get();
    }

    /**
     * @param string $query
     * @return Collection
     */
    public function searchByName(string $query): Collection
    {
        return Organization::where('name', 'LIKE', "%$query%")->get();
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $radius
     * @return Collection
     */
    public function getByRadius(float $latitude, float $longitude, float $radius): Collection
    {
        return Organization::whereHas('building', function ($query) use ($latitude, $longitude, $radius) {
            $query->whereRaw("
            ST_Distance(
                ST_SetSRID(ST_Point(longitude, latitude), 4326)::geography,
                ST_SetSRID(ST_Point(?, ?), 4326)::geography
            ) <= ?
        ", [$longitude, $latitude, $radius * 1000]);
        })->get();
    }
}
