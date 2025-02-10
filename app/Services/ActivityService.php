<?php

namespace App\Services;

use App\Contracts\ActivityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ActivityService
{
    /**
     * @var ActivityRepositoryInterface
     */
    private ActivityRepositoryInterface $activityRepository;

    /**
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * @return Collection
     */
    public function getAllActivities(): Collection
    {
        return $this->activityRepository->getAll();
    }

    /**
     * @return Collection|array
     */
    public function getActivityTree(): Collection|array
    {
        return $this->activityRepository->getTree();
    }
}
