<?php

namespace Repositories;

use App\Contracts\BuildingRepositoryInterface;
use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class BuildingRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(BuildingRepositoryInterface::class);
    }

    public function testGetAllReturnsAllBuildings(): void
    {
        $mockData = new Collection([
            new Building(['id' => 1, 'name' => 'Building A']),
            new Building(['id' => 2, 'name' => 'Building B']),
        ]);

        $this->repository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockData);

        $result = $this->repository->getAll();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Building::class, $result->first());
    }
}