<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('api.v1.activities');
        Route::get('/tree', [ActivityController::class, 'tree'])->name('api.v1.activities.tree');
    });

    Route::prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('api.v1.buildings');
    });

    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'index'])->name('api.v1.organizations.index');
        Route::get('/building/{buildingId}', [OrganizationController::class, 'byBuilding'])
            ->name('api.v1.organizations.building')
            ->where('buildingId', '[0-9]+');
        Route::get('/activity/{activityId}', [OrganizationController::class, 'byActivity'])
            ->name('api.v1.organizations.activity')
            ->where('activityId', '[0-9]+');
        Route::get('/search', [OrganizationController::class, 'search'])->name('api.v1.organizations.search');
        Route::get('/radius', [OrganizationController::class, 'byRadius'])->name('api.v1.organizations.radius');
        Route::get('/{id}', [OrganizationController::class, 'show'])
            ->name('api.v1.organizations.show')
            ->where('id', '[0-9]+');
    });

});
