<?php

namespace App\Repositories;

use App\Contracts\ActivityRepositoryInterface;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function getAll(): Collection
    {
        return Activity::all();
    }

    /**
     * @return Collection|array
     */
    public function getTree(): Collection|array
    {
        return Activity::with('children')->whereNull('parent_id')->get();
    }
}
