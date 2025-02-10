<?php

namespace Services;

use App\Contracts\BuildingRepositoryInterface;
use App\Services\BuildingService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class BuildingServiceTest extends TestCase
{
    private $buildingRepository;
    private BuildingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->buildingRepository = Mockery::mock(BuildingRepositoryInterface::class);
        $this->service = new BuildingService($this->buildingRepository);
    }

    public function testGetAllBuildingsReturnsCollection(): void
    {
        $mockBuildings = new Collection([
            ['id' => 1, 'name' => 'Building A'],
            ['id' => 2, 'name' => 'Building B'],
        ]);

        $this->buildingRepository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockBuildings);

        $result = $this->service->getAllBuildings();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($mockBuildings, $result);
    }
}