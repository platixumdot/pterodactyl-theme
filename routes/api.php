<?php

use Illuminate\Support\Facades\Route;
use Pltx\Theme\Http\Controllers\Api\BillingApiController;
use Pltx\Theme\Http\Controllers\Api\StatusApiController;
use Pltx\Theme\Http\Controllers\Api\UpdateApiController;
use Pltx\Theme\Http\Controllers\Api\TicketApiController;

Route::prefix(config('pltx-theme.api.prefix', 'api/theme'))
    ->middleware(['api'])
    ->group(function (): void {
        Route::get('/status', [StatusApiController::class, 'show']);
        Route::get('/update', [UpdateApiController::class, 'show']);
        Route::get('/tickets', [TicketApiController::class, 'index']);
        Route::post('/tickets', [TicketApiController::class, 'store']);
        Route::get('/billing', [BillingApiController::class, 'index']);
    });
