<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Services\StatusService;

final class StatusApiController
{
    public function __construct(private readonly StatusService $status) {}

    public function show(): JsonResponse
    {
        return response()->json($this->status->apiSummary());
    }
}
