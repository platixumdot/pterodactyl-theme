<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

use Illuminate\Database\Eloquent\Model;

final class ThemeSetting extends Model
{
    protected $connection = 'pltx_theme';
    protected $table      = 'pltx_theme_settings';
    protected $fillable   = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = static::query()->where('key', $key)->first();
        return $row ? $row->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::query()->updateOrInsert(['key' => $key], ['value' => $value]);
    }

    public static function allAsArray(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }
}
