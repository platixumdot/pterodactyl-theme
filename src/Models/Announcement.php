<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class Announcement extends ThemeModel
{
    protected $table = 'pltx_announcements';

    protected $fillable = [
        'type',
        'title',
        'content',
        'is_pinned',
        'published_at',
    ];

    protected $casts = [
        'is_pinned' => 'bool',
        'published_at' => 'datetime',
    ];
}
