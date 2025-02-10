<?php

namespace App\Repositories;

use App\Contracts\BuildingRepositoryInterface;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function getAll(): Collection
    {
        return Building::all();
    }
}