<?php

declare(strict_types=1);

namespace Pltx\Theme\Support;

use Illuminate\Support\Facades\Http;

final class DiscordWebhook
{
    public function __construct(private readonly ?string $url)
    {
    }

    public function send(string $title, string $message, array $meta = []): void
    {
        if ($this->url === null || $this->url === '') {
            return;
        }

        Http::asJson()->post($this->url, [
            'username' => config('pltx-theme.brand.name', 'PLTX Theme'),
            'embeds' => [[
                'title' => $title,
                'description' => $message,
                'color' => 0x3b82f6,
                'fields' => array_map(static fn ($key, $value) => [
                    'name' => (string) $key,
                    'value' => is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE),
                    'inline' => true,
                ], array_keys($meta), $meta),
            ]],
        ]);
    }
}
