<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pltx_status_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 32);
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('status', 32)->default('operational');
            $table->boolean('is_public')->default(true);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
            $table->index(['type', 'status']);
        });

        Schema::create('pltx_tickets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('category', 80);
            $table->string('priority', 24)->default('normal');
            $table->string('subject');
            $table->text('body');
            $table->string('status', 24)->default('open');
            $table->json('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->json('activity')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'priority', 'category']);
        });

        Schema::create('pltx_billing_accounts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('currency', 8)->default('EUR');
            $table->timestamps();
        });

        Schema::create('pltx_billing_transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('billing_account_id')->constrained('pltx_billing_accounts')->cascadeOnDelete();
            $table->string('type', 32);
            $table->decimal('amount', 12, 2);
            $table->string('provider', 32)->nullable();
            $table->string('reference')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('pltx_billing_invoices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('billing_account_id')->constrained('pltx_billing_accounts')->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('status', 24)->default('open');
            $table->decimal('total', 12, 2);
            $table->decimal('paid_total', 12, 2)->default(0);
            $table->timestamp('due_at')->nullable();
            $table->json('lines')->nullable();
            $table->timestamps();
        });

        Schema::create('pltx_vouchers', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('value', 12, 2);
            $table->unsignedInteger('uses_remaining')->default(1);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pltx_user_profiles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->string('banner_path')->nullable();
            $table->text('bio')->nullable();
            $table->json('activity')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('pltx_announcements', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 32)->default('news');
            $table->string('title');
            $table->text('content');
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pltx_system_logs', function (Blueprint $table): void {
            $table->id();
            $table->string('level', 24)->default('info');
            $table->string('source', 80)->nullable();
            $table->string('message');
            $table->json('context')->nullable();
            $table->timestamps();
            $table->index(['level', 'source']);
        });

        Schema::create('pltx_server_metrics', function (Blueprint $table): void {
            $table->id();
            $table->string('server_identifier', 120)->index();
            $table->decimal('cpu', 8, 2)->default(0);
            $table->decimal('memory', 8, 2)->default(0);
            $table->decimal('network_in', 12, 2)->default(0);
            $table->decimal('network_out', 12, 2)->default(0);
            $table->decimal('disk', 8, 2)->default(0);
            $table->json('chart')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pltx_server_metrics');
        Schema::dropIfExists('pltx_system_logs');
        Schema::dropIfExists('pltx_announcements');
        Schema::dropIfExists('pltx_user_profiles');
        Schema::dropIfExists('pltx_vouchers');
        Schema::dropIfExists('pltx_billing_invoices');
        Schema::dropIfExists('pltx_billing_transactions');
        Schema::dropIfExists('pltx_billing_accounts');
        Schema::dropIfExists('pltx_tickets');
        Schema::dropIfExists('pltx_status_entries');
    }
};
