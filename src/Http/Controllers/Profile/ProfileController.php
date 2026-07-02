<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pltx\Theme\Services\ProfileService;

final class ProfileController
{
    public function __construct(private readonly ProfileService $profile) {}

    public function show(Request $request): View
    {
        $profile = $this->profile->getOrCreate($request->user());

        return view('pltx-theme::profile.show', compact('profile'));
    }
}
