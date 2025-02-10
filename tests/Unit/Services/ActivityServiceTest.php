<?php

namespace Services;

use App\Contracts\ActivityRepositoryInterface;
use App\Services\ActivityService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ActivityServiceTest extends TestCase
{
    private $activityRepository;
    private ActivityService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityRepository = Mockery::mock(ActivityRepositoryInterface::class);
        $this->service = new ActivityService($this->activityRepository);
    }

    public function testGetAllActivitiesReturnsCollection(): void
    {
        $mockActivities = new Collection([
            ['id' => 1, 'name' => 'Activity A'],
            ['id' => 2, 'name' => 'Activity B'],
        ]);

        $this->activityRepository->shouldReceive('getAll')
            ->once()
            ->andReturn($mockActivities);

        $result = $this->service->getAllActivities();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($mockActivities, $result);
    }

    public function testGetActivityTreeReturnsTreeStructure(): void
    {
        $mockTree = [
            ['id' => 1, 'name' => 'Activity A', 'children' => [
                ['id' => 2, 'name' => 'Activity B'],
            ]],
        ];

        $this->activityRepository->shouldReceive('getTree')
            ->once()
            ->andReturn($mockTree);

        $result = $this->service->getActivityTree();

        $this->assertEquals($mockTree, $result);
    }
}