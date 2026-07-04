<?php

declare(strict_types=1);

namespace Pltx\Theme\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Pltx\Theme\Support\Update\UpdateChecker;

class UpdateCheckerTest extends TestCase
{
    public function test_has_update_returns_false_when_no_feed(): void
    {
        $checker = new UpdateChecker();
        // Without a feed URL configured, hasUpdate() must return false.
        $this->assertFalse($checker->hasUpdate());
    }
}
