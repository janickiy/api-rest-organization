<?php

namespace tests\Unit\Controllers;

use App\Http\Controllers\Api\ActivityController;
use App\Services\ActivityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class ActivityControllerTest extends TestCase
{
    private $activityService;
    private ActivityController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->activityService = Mockery::mock(ActivityService::class);
        $this->controller = new ActivityController($this->activityService);
    }

    public function testIndexReturnsAllActivities(): void
    {
        $mockActivities = new Collection([
            ['id' => 1, 'name' => 'Activity A'],
            ['id' => 2, 'name' => 'Activity B'],
        ]);

        $this->activityService->shouldReceive('getAllActivities')
            ->once()
            ->andReturn($mockActivities);

        $response = $this->controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockActivities->toArray(), $response->getData(true));
    }

    public function testTreeReturnsActivityTree(): void
    {
        $mockTree = [
            ['id' => 1, 'name' => 'Activity A', 'children' => [
                ['id' => 2, 'name' => 'Activity B'],
            ]],
        ];

        $this->activityService->shouldReceive('getActivityTree')
            ->once()
            ->andReturn($mockTree);

        $response = $this->controller->tree();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($mockTree, $response->getData(true));
    }
}
