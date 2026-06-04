<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ThemeModel extends Model
{
    protected $connection = 'pltx_theme';
}