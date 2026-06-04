<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pltx\Theme\Models\UserProfile;

final class ProfileController
{
    public function show(Request $request): View
    {
        $profile = $request->user()
            ? UserProfile::query()->firstOrCreate(['user_id' => $request->user()->id])
            : null;

        return view('pltx-theme::profile.show', compact('profile'));
    }
}
