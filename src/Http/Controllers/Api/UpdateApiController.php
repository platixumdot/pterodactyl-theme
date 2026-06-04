<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Support\UpdateChecker;

final class UpdateApiController
{
    public function __construct(private readonly UpdateChecker $checker)
    {
    }

    public function show(): JsonResponse
    {
        return response()->json([
            'current' => $this->checker->currentVersion(),
            'latest' => $this->checker->latestVersion(),
            'update_available' => $this->checker->hasUpdate(),
        ]);
    }
}
