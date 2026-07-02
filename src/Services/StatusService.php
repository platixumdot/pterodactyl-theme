<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Pltx\Theme\Models\StatusEntry;

final class StatusService
{
    public function publicEntries(int $perPage = 12): LengthAwarePaginator
    {
        return StatusEntry::query()
            ->where('is_public', true)
            ->latest()
            ->paginate($perPage);
    }

    public function incidents(): Collection
    {
        return StatusEntry::query()
            ->where('type', 'incident')
            ->latest()
            ->get();
    }

    public function apiSummary(): array
    {
        return [
            'status'      => StatusEntry::query()->latest()->first(),
            'incidents'   => StatusEntry::query()->where('type', 'incident')->latest()->take(20)->get(),
            'maintenance' => StatusEntry::query()->where('type', 'maintenance')->latest()->take(20)->get(),
        ];
    }
}
