<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class DiscordAuthController
{
    public function redirect(): RedirectResponse
    {
        $query = http_build_query([
            'client_id' => config('pltx-theme.discord.client_id'),
            'redirect_uri' => route('theme.auth.discord.callback'),
            'response_type' => 'code',
            'scope' => 'identify email',
            'prompt' => 'none',
        ]);

        return redirect()->away('https://discord.com/api/oauth2/authorize?' . $query);
    }

    public function callback(Request $request): RedirectResponse
    {
        $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => config('pltx-theme.discord.client_id'),
            'client_secret' => config('pltx-theme.discord.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $request->string('code')->toString(),
            'redirect_uri' => route('theme.auth.discord.callback'),
        ]);

        if (! $response->successful()) {
            return redirect()->route('theme.login')->with('status', 'Discord-Login fehlgeschlagen.');
        }

        return redirect()->route('theme.home')->with('status', 'Discord-Login erfolgreich.');
    }
}
