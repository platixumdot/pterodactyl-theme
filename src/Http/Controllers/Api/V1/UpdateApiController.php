<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Services\UpdateService;

final class UpdateApiController
{
    public function __construct(private readonly UpdateService $update) {}

    public function show(): JsonResponse
    {
        return response()->json($this->update->getUpdateStatus());
    }
}
