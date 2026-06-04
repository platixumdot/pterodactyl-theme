<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class Ticket extends Model
{
    protected $table = 'pltx_tickets';

    protected $fillable = [
        'user_id',
        'category',
        'priority',
        'subject',
        'body',
        'status',
        'notes',
        'attachments',
        'activity',
        'closed_at',
        'archived_at',
    ];

    protected $casts = [
        'notes' => 'array',
        'attachments' => 'array',
        'activity' => 'array',
        'closed_at' => 'datetime',
        'archived_at' => 'datetime',
    ];
}
