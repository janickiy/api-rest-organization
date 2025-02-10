<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * @var OrganizationService
     */
    private OrganizationService $organizationService;

    /**
     * @param OrganizationService $organizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->organizationService->getAllOrganizations());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $organization = $this->organizationService->getOrganizationById($id);

        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        return response()->json($organization);
    }

    /**
     * @param $buildingId
     * @return JsonResponse
     */
    public function byBuilding($buildingId): JsonResponse
    {
        return response()->json($this->organizationService->getOrganizationsByBuilding($buildingId));
    }

    /**
     * @param $activityId
     * @return JsonResponse
     */
    public function byActivity(int $activityId): JsonResponse
    {
        return response()->json($this->organizationService->getOrganizationsByActivity($activityId));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');
        return response()->json($this->organizationService->searchOrganizations($query));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function byRadius(Request $request): JsonResponse
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        return response()->json(
            $this->organizationService->getOrganizationsByRadius($latitude, $longitude, $radius)
        );
    }
}
