<?php

namespace tests\Unit\Repositories;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrganizationRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(OrganizationRepositoryInterface::class);
    }

    public function testGetAllReturnsAllOrganizations(): void
    {
        $mockData = new Collection([
            new Organization(['id' => 1, 'name' => 'Organization A']),
            new Organization(['id' => 2, 'name' => 'Organization B']),
        ]);

        $this->repository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockData);

        $result = $this->repository->getAll();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Organization::class, $result->first());
    }

    public function testGetByIdReturnsOrganizationWhenFound(): void
    {
        $mockOrganization = new Organization(['name' => 'Organization A']);
        $mockOrganization->setAttribute('id', 1);

        $this->repository->shouldReceive('getById')
            ->with(1)
            ->once()
            ->andReturn($mockOrganization);

        $result = $this->repository->getById(1);

        $this->assertNotNull($result);
        $this->assertInstanceOf(Organization::class, $result);
        $this->assertEquals(1, $result->id);
    }

    public function testGetByIdReturnsNullWhenNotFound(): void
    {
        $this->repository->shouldReceive('getById')
            ->with(999)
            ->once()
            ->andReturn(null);

        $result = $this->repository->getById(999);

        $this->assertNull($result);
    }

    public function testGetByBuildingReturnsOrganizationsForBuilding(): void
    {
        $mockData = new Collection([
            new Organization(['id' => 1, 'building_id' => 1]),
            new Organization(['id' => 2, 'building_id' => 1]),
        ]);

        $this->repository->shouldReceive('getByBuilding')
            ->with(1)
            ->once()
            ->andReturn($mockData);

        $result = $this->repository->getByBuilding(1);

        $this->assertCount(2, $result);
        $this->assertEquals(1, $result->first()->building_id);
    }

    public function testSearchByNameReturnsMatchingOrganizations(): void
    {
        $mockData = new Collection([
            new Organization(['id' => 1, 'name' => 'Organization A']),
            new Organization(['id' => 2, 'name' => 'Organization B']),
        ]);

        $this->repository->shouldReceive('searchByName')
            ->with('Organization')
            ->once()
            ->andReturn($mockData);

        $result = $this->repository->searchByName('Organization');

        $this->assertCount(2, $result);
        $this->assertEquals('Organization A', $result->first()->name);
    }
}