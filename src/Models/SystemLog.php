<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class SystemLog extends ThemeModel
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
