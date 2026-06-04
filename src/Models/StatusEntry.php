<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class StatusEntry extends Model
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
