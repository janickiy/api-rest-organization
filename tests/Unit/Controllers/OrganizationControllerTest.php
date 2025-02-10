<?php

namespace tests\Unit\Controllers;

use App\Contracts\OrganizationRepositoryInterface;
use App\Http\Controllers\Api\OrganizationController;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class OrganizationControllerTest extends TestCase
{
    private $repository;
    private $organizationService;
    private OrganizationController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(OrganizationRepositoryInterface::class);
        $this->app->instance(OrganizationRepositoryInterface::class, $this->repository);
        $this->organizationService = Mockery::mock(OrganizationService::class);
        $this->controller = new OrganizationController($this->organizationService);
    }

    public function testIndexReturnsAllOrganizations(): void
    {
        $mockData = new Collection([
            ['id' => 1, 'name' => 'Organization A'],
            ['id' => 2, 'name' => 'Organization B']
        ]);

        $this->organizationService->shouldReceive('getAllOrganizations')
            ->once()
            ->andReturn($mockData);

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockData->toArray(), $response->getData(true));
    }

    public function testShowReturnsOrganizationWhenFound(): void
    {
        $mockOrganization = new Organization(['id' => 1, 'name' => 'Organization A']);

        $this->organizationService->shouldReceive('getOrganizationById')
            ->with(1)
            ->once()
            ->andReturn($mockOrganization);

        $response = $this->controller->show(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockOrganization->toArray(), $response->getData(true));
    }

    public function testShowReturnsNotFoundWhenOrganizationDoesNotExist(): void
    {
        $this->organizationService->shouldReceive('getOrganizationById')
            ->with(999)
            ->once()
            ->andReturn(null);

        $response = $this->controller->show(999);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->status());
        $this->assertEquals(['message' => 'Organization not found'], $response->getData(true));
    }

    public function testByBuildingReturnsOrganizations(): void
    {
        $mockData = new Collection([
            ['id' => 1, 'name' => 'Organization A'],
            ['id' => 2, 'name' => 'Organization B']
        ]);

        $this->organizationService->shouldReceive('getOrganizationsByBuilding')
            ->with(1)
            ->once()
            ->andReturn($mockData);

        $response = $this->controller->byBuilding(1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockData->toArray(), $response->getData(true));
    }

    public function testSearchReturnsMatchingOrganizations(): void
    {
        $mockData = new Collection([
            ['id' => 1, 'name' => 'Organization A']
        ]);

        $request = new Request(['query' => 'A']);

        $this->organizationService->shouldReceive('searchOrganizations')
            ->with('A')
            ->once()
            ->andReturn($mockData);

        $response = $this->controller->search($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockData->toArray(), $response->getData(true));
    }

    public function testByRadiusReturnsOrganizationsWithinRadius(): void
    {
        $mockData = new Collection([
            new Organization(['id' => 1, 'name' => 'Organization A']),
        ]);

        $request = new Request([
            'latitude' => 55.7558,
            'longitude' => 37.6173,
            'radius' => 5
        ]);

        $this->organizationService->shouldReceive('getOrganizationsByRadius')
            ->with(55.7558, 37.6173, 5)
            ->once()
            ->andReturn($mockData);

        $response = $this->controller->byRadius($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockData->toArray(), $response->getData(true));
    }
}
