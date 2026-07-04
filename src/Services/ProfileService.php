<?php

declare(strict_types=1);

namespace Pltx\Theme\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Pltx\Theme\Models\UserProfile;

final class ProfileService
{
    public function getOrCreate(?Authenticatable $user): ?UserProfile
    {
        if ($user === null) {
            return null;
        }

        return UserProfile::query()->firstOrCreate(['user_id' => $user->getAuthIdentifier()]);
    }
}
