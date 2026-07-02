<?php

declare(strict_types=1);

namespace Pltx\Theme\Policies;

use Illuminate\Contracts\Auth\Authenticatable;

final class BillingPolicy
{
    public function view(Authenticatable $user): bool
    {
        return method_exists($user, 'isRootAdmin') && $user->isRootAdmin();
    }
}
