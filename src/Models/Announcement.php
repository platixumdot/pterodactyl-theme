<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class Announcement extends Model
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
