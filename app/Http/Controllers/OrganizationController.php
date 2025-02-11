<?php

namespace App\Http\Controllers;

use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Organization\RadiusRequest;

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
     * @OA\Get(
     *     path="/api/v1/organizations",
     *     summary="Список всех организаций,",
     *     @OA\Response(
     *         response=200,
     *         description="Список всех организаций,",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->organizationService->getAllOrganizations());
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/{show}",
     *     summary="Вывод информации об организации по её идентификатору",
     *     @OA\Response(
     *         response=200,
     *         description="Вывод информации об организации по её идентификатору",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $organization = $this->organizationService->getOrganizationById($id);

        if (!$organization) {
            return response()->json(['message' => 'Organization not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($organization);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/{$buildingId}",
     *     summary="Список всех организаций, находящихся в конкретном здании",
     *     @OA\Response(
     *         response=200,
     *         description="Список всех организаций, находящихся в конкретном здании",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function byBuilding(int $buildingId): JsonResponse
    {
        return response()->json($this->organizationService->getOrganizationsByBuilding($buildingId));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/{$activityId}",
     *     summary="Список всех организаций, относящихся к указанному виду деятельности",
     *     @OA\Response(
     *         response=200,
     *         description="Список всех организаций, относящихся к указанному виду деятельности",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function byActivity(int $activityId): JsonResponse
    {
        return response()->json($this->organizationService->getOrganizationsByActivity($activityId));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/search",
     *     summary="Поиск организаций по названию",
     *     @OA\Response(
     *         response=200,
     *         description="Поиск организаций по названию",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->input('query');
        return response()->json($this->organizationService->searchOrganizations($query));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/radius",
     *     summary="Список организаций, которые находятся в заданном радиусе относительно точки на карте",
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций, которые находятся в заданном радиусе относительно точки на картею",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="string", example="{}"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     )
     * )
     */
    public function byRadius(RadiusRequest $request): JsonResponse
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');

        return response()->json(
            $this->organizationService->getOrganizationsByRadius($latitude, $longitude, $radius)
        );
    }
}
