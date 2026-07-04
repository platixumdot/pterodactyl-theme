<?php

declare(strict_types=1);

namespace Pltx\Theme\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Pltx\Theme\Http\Requests\Ticket\StoreTicketRequest;
use Pltx\Theme\Models\Ticket;
use Pltx\Theme\Services\TicketService;

final class TicketApiController
{
    public function __construct(private readonly TicketService $tickets) {}

    public function index(): JsonResponse
    {
        return response()->json(Ticket::query()->latest()->paginate(20));
    }

    public function store(StoreTicketRequest $request): JsonResponse
    {
        $ticket = $this->tickets->create($request->validated(), $request->user()?->id);

        return response()->json($ticket, 201);
    }
}
