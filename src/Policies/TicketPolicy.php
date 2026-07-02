<?php

declare(strict_types=1);

namespace Pltx\Theme\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Pltx\Theme\Models\Ticket;

final class TicketPolicy
{
    public function view(Authenticatable $user, Ticket $ticket): bool
    {
        return $ticket->user_id === $user->getAuthIdentifier()
            || $this->isAdmin($user);
    }

    public function close(Authenticatable $user, Ticket $ticket): bool
    {
        return $this->isAdmin($user);
    }

    public function archive(Authenticatable $user, Ticket $ticket): bool
    {
        return $this->isAdmin($user);
    }

    public function addNote(Authenticatable $user, Ticket $ticket): bool
    {
        return $this->isAdmin($user);
    }

    private function isAdmin(Authenticatable $user): bool
    {
        return method_exists($user, 'isRootAdmin') && $user->isRootAdmin();
    }
}
