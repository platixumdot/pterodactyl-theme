<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Services\BillingService;

final class BillingApiController
{
    public function __construct(private readonly BillingService $billing) {}

    public function index(): JsonResponse
    {
        return response()->json($this->billing->getApiSummary());
    }
}
