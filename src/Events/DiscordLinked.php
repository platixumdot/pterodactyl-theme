<?php

declare(strict_types=1);

namespace Pltx\Theme\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class DiscordLinked
{
    use Dispatchable, SerializesModels;

    public function __construct(public readonly array $tokenData) {}
}
