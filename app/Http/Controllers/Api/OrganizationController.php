<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\RadiusRequest;
use App\Http\Requests\Organization\QueryRequest;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
     *     summary="Список всех организаций",
     *     @OA\Response(
     *         response=200,
     *         description="Получить список всех организаций",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="building_id", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
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
     *     path="/api/v1/organizations/{id}",
     *     summary="Вывод информации об организации по её идентификатору",
     *     @OA\Parameter(
     *          name="id",
     *          description="Инденитификатор организации",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Вывод информации об организации по её идентификатору",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="building_id", description="ID здания", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
     *             @OA\Property(property="phone_numbers", type="array", @OA\Items(type="string"), description="array of phones"),
     *             @OA\Property(property="created_at", type="string", example="2024-05-20T14:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2024-05-20T14:00:00.000000Z")
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
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
     *     path="/api/v1/organizations/{buildingId}",
     *     summary="Список организаций в здании",
     *     @OA\Parameter(
     *          name="buildingId",
     *          description="ID здания",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Получить список организаций по ID здания",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
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
     *     path="/api/v1/organizations/{activityId}",
     *     summary="Список организаций в здании",
     *     @OA\Parameter(
     *          name="activityId",
     *          description="ID вида деятельности",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Список всех организаций, относящихся к указанному виду деятельности",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
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
     *     @OA\Parameter(
     *          name="query",
     *          description="Поисковая строка",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Поиск организаций по названию",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="code", type="number", example=422),
     *                 @OA\Property(property="status", type="string", example="error"),
     *                 @OA\Property(property="message", type="object",
     *                     @OA\Property(property="email", type="array", collectionFormat="multi",
     *                        @OA\Items(
     *                          type="string",
     *                          example="The query field is required.",
     *                          )
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property="data", type="object", example={}),
     *          )
     *     )
     * )
     */
    public function search(QueryRequest $request): JsonResponse
    {
        $query = $request->input('query');
        return response()->json($this->organizationService->searchOrganizations($query));
    }

    /**
     * @OA\Get(
     *     path="/api/v1/organizations/radius",
     *     summary="Список организаций в радиусе",
     *     @OA\Parameter(
     *          name="latitude",
     *          description="Широта центральной точки",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="number", format="float")
     *      ),
     *     @OA\Parameter(
     *           name="longitude",
     *           description="Долгота центральной точки",
     *           in="query",
     *           required=true,
     *           @OA\Schema(type="number", format="float")
     *       ),
     *     @OA\Parameter(
     *            name="radius",
     *            description="Радиус в километрах",
     *            in="query",
     *            required=true,
     *            @OA\Schema(type="number", format="float")
     *        ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций, которые находятся в заданном радиусе относительно точки на картею",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", description="ID организации", type="integer", example=1),
     *             @OA\Property(property="name", description="Название организации", type="string", example="ООО Рога и Копыта"),
     *         )
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Организация не найдена",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Organization not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="code", type="number", example=422),
     *                  @OA\Property(property="status", type="string", example="error"),
     *                  @OA\Property(property="message", type="object",
     *                      @OA\Property(property="email", type="array", collectionFormat="multi",
     *                         @OA\Items(
     *                           type="string",
     *                           example="The latitude field is required.",
     *                          )
     *                       ),
     *                   ),
     *               ),
     *               @OA\Property(property="data", type="object", example={}),
     *           )
     *      )
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
