<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TicketAnswer;
use App\Models\Ticket;
use App\Services\DataTables;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mail;

class TicketsController extends Controller
{
    public function index(): View
    {
        $tickets = (new DataTables(Ticket::latest()))
            ->add('is_resolved', __('admin.tickets.fields.is_resolved'))
            ->add('user', __('admin.users.fields.name'), false)
            ->add('created_at', __('admin.fields.created_at'))
            ->paginate();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket): View
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function handle(Ticket $ticket): RedirectResponse
    {
        $ticket->is_resolved = !$ticket->is_resolved;
        $ticket->save();

        return back();
    }

    public function answer(Ticket $ticket, Request $request)
    {
        if (!$ticket->user_id) {
            return abort(419);
        }
        Mail::to($ticket->user->email)->send(new TicketAnswer($ticket, $request->answer));
            return back()->with('success', __('admin.messages.answered'));
    }
}
