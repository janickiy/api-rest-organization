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
     * @OA\Get(
     *     path="/api/v1/activities",
     *     summary="Список всех видов деятельности",
     *     @OA\Response(
     *         response=200,
     *         description="Получить список всех видов деятельности",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="Уникальный идентификатор вида деятельности", type="integer", example=1),
     *             @OA\Property(property="parent_id", description="ID родительской деятельности, если есть", type="integer", example=1),
     *             @OA\Property(property="name", description="Название вида деятельности", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->activityService->getAllActivities());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/activities/tree",
     *     summary="Дерево видов деятельности",
     *     @OA\Response(
     *         response=200,
     *         description="Уникальный идентификатор вида деятельности",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="Уникальный идентификатор вида деятельности", type="integer", example=1),
     *             @OA\Property(property="parent_id", description="ID родительской деятельности, если есть", type="integer", example=1),
     *             @OA\Property(property="name", description="Название вида деятельности", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function tree(): JsonResponse
    {
        return response()->json($this->activityService->getActivityTree());
    }
}
