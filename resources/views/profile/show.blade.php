@extends('pltx-theme::layouts.app')

@section('title', 'Profil')

@section('content')
<div class="page-header">
    <h2>Profil</h2>
    <p>Deine Profil-Einstellungen.</p>
</div>

<div class="pltx-card" style="max-width:520px;">
    <div class="pltx-card__body">
        @if($profile)
        <div class="pltx-field">
            <label class="pltx-label">Benutzer-ID</label>
            <input type="text" class="pltx-input" value="{{ $profile->user_id }}" readonly style="opacity:.7;">
        </div>
        @if($profile->bio)
        <div class="pltx-field">
            <label class="pltx-label">Bio</label>
            <textarea class="pltx-input pltx-textarea" readonly style="opacity:.7;">{{ $profile->bio }}</textarea>
        </div>
        @endif
        @else
        <p class="text-muted">Kein Profil gefunden.</p>
        @endif
    </div>
</div>
@endsection
