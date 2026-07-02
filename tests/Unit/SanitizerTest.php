<?php

declare(strict_types=1);

namespace Pltx\Theme\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Pltx\Theme\Support\Security\Sanitizer;

class SanitizerTest extends TestCase
{
    public function test_text_strips_tags(): void
    {
        $result = Sanitizer::text('<b>Hello</b> World');
        $this->assertSame('Hello World', $result);
    }

    public function test_text_respects_max_length(): void
    {
        $result = Sanitizer::text('Hello World', 5);
        $this->assertSame('Hello', $result);
    }

    public function test_html_removes_scripts(): void
    {
        $result = Sanitizer::html('<script>alert(1)</script><p>Safe</p>');
        $this->assertStringContainsString('<p>Safe</p>', (string) $result);
        $this->assertStringNotContainsString('<script>', (string) $result);
    }

    public function test_null_returns_null(): void
    {
        $this->assertNull(Sanitizer::text(null));
        $this->assertNull(Sanitizer::html(null));
    }
}
