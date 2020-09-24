<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;

class TicketObserver
{
    /**
     * Handle the ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $admins = User::whereRole('admin')->get();

        \Notification::send($admins, new TicketCreated($ticket));
    }

    /**
     * Handle the ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        //
    }
}
