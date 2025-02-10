<?php

namespace Repositories;

use App\Contracts\ActivityRepositoryInterface;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ActivityRepositoryTest extends TestCase
{
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(ActivityRepositoryInterface::class);
    }

    public function testGetAllReturnsAllActivities(): void
    {
        $mockData = new Collection([
            new Activity(['id' => 1, 'name' => 'Activity A']),
            new Activity(['id' => 2, 'name' => 'Activity B']),
        ]);

        $this->repository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockData);

        $result = $this->repository->getAll();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Activity::class, $result->first());
    }

    public function testGetTreeReturnsActivityTree(): void
    {
        $parentActivity = new Activity();
        $parentActivity->setAttribute('id', 1);
        $parentActivity->setAttribute('name', 'Parent Activity');
        $childActivity = new Activity();
        $childActivity->setAttribute('id', 2);
        $childActivity->setAttribute('name', 'Child Activity');
        $parentActivity->setRelation('children', new Collection([$childActivity]));
        $mockTree = new Collection([$parentActivity]);

        $this->repository->shouldReceive('getTree')
            ->once()
            ->andReturn($mockTree);

        $result = $this->repository->getTree();

        $this->assertCount(1, $result);
        $this->assertEquals(1, $result->first()->id);
        $this->assertCount(1, $result->first()->children);
    }
}