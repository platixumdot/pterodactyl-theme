@php($checker = app(\Pltx\Theme\Support\UpdateChecker::class))
@if($checker->hasUpdate())
    <div class="alert" style="background: rgba(59, 130, 246, 0.14);">
        Ein Update auf Version {{ $checker->latestVersion() }} ist verfügbar.
    </div>
@endif
