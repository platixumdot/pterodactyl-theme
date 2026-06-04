<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Models\StatusEntry;

final class StatusApiController
{
    public function show(): JsonResponse
    {
        return response()->json([
            'status' => StatusEntry::query()->latest()->first(),
            'incidents' => StatusEntry::query()->where('type', 'incident')->latest()->take(20)->get(),
            'maintenance' => StatusEntry::query()->where('type', 'maintenance')->latest()->take(20)->get(),
        ]);
    }
}
