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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->buildingService->getAllBuildings());
    }
}
