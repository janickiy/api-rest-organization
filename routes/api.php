<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/building/{buildingId}', [OrganizationController::class, 'byBuilding']);
        Route::get('/activity/{activityId}', [OrganizationController::class, 'byActivity']);
        Route::get('/search', [OrganizationController::class, 'search']);
        Route::get('/radius', [OrganizationController::class, 'byRadius']);
        Route::get('/{id}', [OrganizationController::class, 'show']);
    });

    Route::prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index']);
    });

    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);
        Route::get('/tree', [ActivityController::class, 'tree']);
    });

});
