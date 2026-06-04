<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class SystemLog extends Model
{
    protected $table = 'pltx_system_logs';

    protected $fillable = [
        'level',
        'source',
        'message',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
