<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Pltx\Theme\Support\Update\UpdateChecker;

final class UpdateService
{
    public function __construct(private readonly UpdateChecker $checker) {}

    public function getUpdateStatus(): array
    {
        return [
            'current'          => $this->checker->currentVersion(),
            'latest'           => $this->checker->latestVersion(),
            'update_available' => $this->checker->hasUpdate(),
        ];
    }
}
