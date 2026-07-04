<?php

declare(strict_types=1);

namespace Pltx\Theme\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pltx\Theme\Support\Discord\DiscordWebhook;

final class SendDiscordWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $title,
        private readonly string $message,
        private readonly array  $meta = [],
    ) {}

    public function handle(DiscordWebhook $webhook): void
    {
        $webhook->send($this->title, $this->message, $this->meta);
    }
}
