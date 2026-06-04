<?php

declare(strict_types=1);

namespace Pltx\Theme\Models;

final class UserProfile extends ThemeModel
{
    protected $table = 'pltx_user_profiles';

    protected $fillable = [
        'user_id',
        'banner_path',
        'bio',
        'activity',
        'settings',
    ];

    protected $casts = [
        'activity' => 'array',
        'settings' => 'array',
    ];
}
