<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    private ActivityService $activityService;

    /**
     * @param ActivityService $activityService
     */
    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->activityService->getAllActivities());
    }

    /**
     * @return JsonResponse
     */
    public function tree(): JsonResponse
    {
        return response()->json($this->activityService->getActivityTree());
    }
}
