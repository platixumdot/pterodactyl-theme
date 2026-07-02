<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Pltx\Theme\Services\DiscordAuthService;

final class DiscordAuthController
{
    public function __construct(private readonly DiscordAuthService $discord) {}

    public function redirect(): RedirectResponse
    {
        return redirect()->away($this->discord->buildRedirectUrl());
    }

    public function callback(Request $request): RedirectResponse
    {
        $result = $this->discord->exchangeCode($request->string('code')->toString());

        if ($result === null) {
            return redirect()->route('theme.login')->with('status', 'Discord-Login fehlgeschlagen.');
        }

        return redirect()->route('theme.home')->with('status', 'Discord-Login erfolgreich.');
    }
}
