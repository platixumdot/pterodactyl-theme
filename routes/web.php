<?php

use Illuminate\Support\Facades\Route;
use Pltx\Theme\Http\Controllers\Auth\DiscordAuthController;
use Pltx\Theme\Http\Controllers\AdminController;
use Pltx\Theme\Http\Controllers\BillingController;
use Pltx\Theme\Http\Controllers\ProfileController;
use Pltx\Theme\Http\Controllers\ServerController;
use Pltx\Theme\Http\Controllers\StatusController;
use Pltx\Theme\Http\Controllers\TicketController;

Route::middleware(['web'])->group(function (): void {
    Route::view('/', 'pltx-theme::dashboard.index')->name('theme.home');
    Route::view('/login', 'pltx-theme::auth.login')->name('theme.login');
    Route::view('/errors/404', 'pltx-theme::errors.404')->name('theme.error.404');
    Route::view('/errors/500', 'pltx-theme::errors.500')->name('theme.error.500');

    Route::get('/status', [StatusController::class, 'index'])->name('theme.status');
    Route::get('/status/incidents', [StatusController::class, 'incidents'])->name('theme.status.incidents');
    Route::get('/tickets', [TicketController::class, 'index'])->name('theme.tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('theme.tickets.store');
    Route::post('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('theme.tickets.close');
    Route::post('/tickets/{ticket}/archive', [TicketController::class, 'archive'])->name('theme.tickets.archive');
    Route::post('/tickets/{ticket}/notes', [TicketController::class, 'note'])->name('theme.tickets.note');
    Route::get('/billing', [BillingController::class, 'index'])->name('theme.billing.index');
    Route::get('/profile', [ProfileController::class, 'show'])->name('theme.profile.show');
    Route::get('/servers/{server}', [ServerController::class, 'show'])->name('theme.servers.show');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('theme.admin.dashboard');

    Route::prefix('auth/discord')->name('theme.auth.discord.')->group(function (): void {
        Route::get('/redirect', [DiscordAuthController::class, 'redirect'])->name('redirect');
        Route::get('/callback', [DiscordAuthController::class, 'callback'])->name('callback');
    });
});
