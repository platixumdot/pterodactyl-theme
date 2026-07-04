<?php

declare(strict_types=1);

namespace Pltx\Theme\Support\Security;

final class Sanitizer
{
    public static function text(?string $value, int $maxLength = 255): ?string
    {
        if ($value === null) {
            return null;
        }

        $clean = preg_replace('/\s+/u', ' ', trim(strip_tags($value)));

        if ($clean === null || $clean === '') {
            return null;
        }

        return mb_substr($clean, 0, $maxLength);
    }

    public static function html(?string $value, int $maxLength = 10000): ?string
    {
        if ($value === null) {
            return null;
        }

        $clean = trim($value);
        $clean = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $clean) ?? $clean;
        $clean = strip_tags($clean, '<p><br><strong><em><ul><ol><li><a><code><pre><blockquote><h1><h2><h3><h4><h5><h6>');

        return mb_substr($clean, 0, $maxLength);
    }
}
