<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    
    public function viewAny(User $user): bool
    {
        return true;
    }

    
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->role === 'agent' || $user->role === 'admin') {
            return true;
        }

        return $user->id === $ticket->customer_id;
    }

    
    public function create(User $user): bool
    {
        return true;
    }

    
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->role === 'agent' || $user->role === 'admin';
    }

    
    public function reply(User $user, Ticket $ticket): bool
    {
        if ($user->role === 'agent' || $user->role === 'admin') {
            return true;
        }

        return $user->id === $ticket->customer_id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === 'admin';
    }
}