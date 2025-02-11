<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;

class BuildingController extends Controller
{
    /**
     * @var BuildingService
     */
    private BuildingService $buildingService;

    /**
     * @param BuildingService $buildingService
     */
    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/buildings",
     *     summary="Список всех зданий",
     *     @OA\Response(
     *         response=200,
     *         description="Получить список всех зданий",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="Уникальный идентификатор здания", type="integer", example=1),
     *             @OA\Property(property="address", description="Адрес здания", type="string", example="г. Москва, ул. Ленина 1, офис 3"),
     *             @OA\Property(property="latitude", description="", type="float", example="55.7558000"),
     *             @OA\Property(property="longitude", description="", type="float", example="37.6173000"),
     *             @OA\Property(property="created_at", type="string", example="2025-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2025-05-20T14:00:00.000000Z")
     *         )
     *     ),
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->buildingService->getAllBuildings());
    }
}
