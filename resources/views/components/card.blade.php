@props(['title' => null])
<div class="pltx-card">
    @if($title)
        <div class="pltx-card__header">{{ $title }}</div>
    @endif
    <div class="pltx-card__body">{{ $slot }}</div>
</div>
