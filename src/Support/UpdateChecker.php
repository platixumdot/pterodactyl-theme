<?php

declare(strict_types=1);

namespace Pltx\Theme\Support;

use Illuminate\Support\Facades\Http;

final class UpdateChecker
{
    public function currentVersion(): string
    {
        return (string) config('pltx-theme.version', '1.0.0');
    }

    public function latestVersion(): ?string
    {
        $feedUrl = config('pltx-theme.updates.feed_url');

        if (! is_string($feedUrl) || $feedUrl === '') {
            return null;
        }

        $response = Http::timeout(5)->acceptJson()->get($feedUrl);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('version');
    }

    public function hasUpdate(): bool
    {
        $latest = $this->latestVersion();

        if (! is_string($latest) || $latest === '') {
            return false;
        }

        return version_compare($latest, $this->currentVersion(), '>');
    }
}
