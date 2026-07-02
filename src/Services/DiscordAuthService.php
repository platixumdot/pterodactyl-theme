<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Pltx\Theme\Events\DiscordLinked;

final class DiscordAuthService
{
    public function buildRedirectUrl(): string
    {
        return 'https://discord.com/api/oauth2/authorize?' . http_build_query([
            'client_id'     => config('pltx-theme.discord.client_id'),
            'redirect_uri'  => route('theme.auth.discord.callback'),
            'response_type' => 'code',
            'scope'         => 'identify email',
            'prompt'        => 'none',
        ]);
    }

    public function exchangeCode(string $code): ?array
    {
        $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id'     => config('pltx-theme.discord.client_id'),
            'client_secret' => config('pltx-theme.discord.client_secret'),
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => route('theme.auth.discord.callback'),
        ]);

        if (! $response->successful()) {
            return null;
        }

        $tokenData = $response->json();
        event(new DiscordLinked($tokenData));

        return $tokenData;
    }
}
