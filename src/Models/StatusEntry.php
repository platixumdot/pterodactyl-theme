<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class StatusEntry extends ThemeModel
{
    protected $table = 'pltx_status_entries';

    protected $fillable = [
        'type',
        'title',
        'message',
        'status',
        'is_public',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_public' => 'bool',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
