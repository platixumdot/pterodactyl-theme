<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class ServerMetric extends Model
{
    protected $table = 'pltx_server_metrics';

    protected $fillable = [
        'server_identifier',
        'cpu',
        'memory',
        'network_in',
        'network_out',
        'disk',
        'chart',
    ];

    protected $casts = [
        'cpu' => 'decimal:2',
        'memory' => 'decimal:2',
        'network_in' => 'decimal:2',
        'network_out' => 'decimal:2',
        'disk' => 'decimal:2',
        'chart' => 'array',
    ];
}
