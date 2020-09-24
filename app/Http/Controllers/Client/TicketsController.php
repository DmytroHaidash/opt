<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\TickerCreationRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * @param TickerCreationRequest $request
     * @return RedirectResponse
     */
    public function create(TickerCreationRequest $request): RedirectResponse
    {
        $ticket = Ticket::create(array_merge(
            $request->only('name', 'phone', 'message', 'subject'),
            [
                'user_id' => \Auth::check() ? \Auth::user()->id : null
            ]
        ));

        return back()->with('success', __('support.success', ['ticket' => $ticket->id]));
    }
}
