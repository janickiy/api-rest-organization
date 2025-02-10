<?php

namespace tests\Unit\Services;

use App\Contracts\OrganizationRepositoryInterface;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrganizationServiceTest extends TestCase
{
    private $repository;
    private OrganizationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(OrganizationRepositoryInterface::class);
        $this->service = new OrganizationService($this->repository);
    }

    public function testGetAllOrganizations(): void
    {
        $mockData = new Collection([
            ['id' => 1, 'name' => 'Organization A'],
        ]);

        $this->repository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockData);

        $result = $this->service->getAllOrganizations();

        $this->assertEquals($mockData, $result);
    }

    public function testGetOrganizationById(): void
    {
        $mockOrganization = new Organization(['id' => 1, 'name' => 'Organization A']);

        $this->repository->shouldReceive('getById')
            ->with(1)
            ->once()
            ->andReturn($mockOrganization);

        $result = $this->service->getOrganizationById(1);

        $this->assertEquals($mockOrganization, $result);
    }

    public function testSearchOrganizations(): void
    {
        $mockData = new Collection([
            new Organization(['id' => 1, 'name' => 'Organization A']),
        ]);

        $this->repository->shouldReceive('searchByName')
            ->with('A')
            ->once()
            ->andReturn($mockData);

        $result = $this->service->searchOrganizations('A');

        $this->assertEquals($mockData, $result);
    }
}