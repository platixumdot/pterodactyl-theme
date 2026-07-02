<?php

declare(strict_types=1);

namespace Pltx\Theme\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use Pltx\Theme\ThemeServiceProvider;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [ThemeServiceProvider::class];
    }

    public function test_ticket_list_returns_200(): void
    {
        $response = $this->get(config('pltx-theme.routes.web_prefix', 'theme') . '/tickets');
        $response->assertStatus(200);
    }
}
