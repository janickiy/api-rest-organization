<?php

namespace tests\Unit\Controllers;

use App\Http\Controllers\Api\BuildingController;
use App\Services\BuildingService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class BuildingControllerTest extends TestCase
{
    private $buildingService;
    private BuildingController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildingService = Mockery::mock(BuildingService::class);
        $this->controller = new BuildingController($this->buildingService);
    }

    public function testIndexReturnsAllBuildings(): void
    {
        $mockBuildings = new Collection([
            ['id' => 1, 'name' => 'Building A'],
            ['id' => 2, 'name' => 'Building B'],
        ]);

        $this->buildingService->shouldReceive('getAllBuildings')
            ->once()
            ->andReturn($mockBuildings);

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockBuildings->toArray(), $response->getData(true));
    }
}
