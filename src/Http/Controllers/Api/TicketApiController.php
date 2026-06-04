<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Support\Sanitizer;

final class TicketApiController
{
    public function index(): JsonResponse
    {
        return response()->json(Ticket::query()->latest()->paginate(20));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'priority' => ['required', 'in:low,normal,high,urgent'],
            'subject' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:10000'],
        ]);

        $ticket = Ticket::query()->create([
            'user_id' => $request->user()?->id,
            'category' => Sanitizer::text($data['category'], 80) ?? 'general',
            'priority' => $data['priority'],
            'subject' => Sanitizer::text($data['subject'], 150) ?? $data['subject'],
            'body' => Sanitizer::html($data['body'], 10000) ?? $data['body'],
            'status' => 'open',
        ]);

        return response()->json($ticket, 201);
    }
}
