<?php

use Illuminate\Support\Facades\Route;
use Pltx\Theme\Http\Controllers\Api\V1\BillingApiController;
use Pltx\Theme\Http\Controllers\Api\V1\StatusApiController;
use Pltx\Theme\Http\Controllers\Api\V1\UpdateApiController;
use Pltx\Theme\Http\Controllers\Api\V1\TicketApiController;

Route::prefix(config('pltx-api.prefix', 'api/theme'))
    ->middleware(['api'])
    ->group(function (): void {
        Route::prefix('v1')->group(function (): void {
            Route::get('/status', [StatusApiController::class, 'show']);
            Route::get('/update', [UpdateApiController::class, 'show']);
            Route::get('/tickets', [TicketApiController::class, 'index']);
            Route::post('/tickets', [TicketApiController::class, 'store']);
            Route::get('/billing', [BillingApiController::class, 'index']);
        });
    });
