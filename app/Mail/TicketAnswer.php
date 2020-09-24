<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketAnswer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Ticket
     */
    public $ticket;

    /**
     * @var string
     */
    public $answer;

    /**
     * TicketAnswer constructor.
     * @param Ticket $ticket
     * @param string $answer
     */
    public function __construct(Ticket $ticket, string $answer)
    {
        $this->ticket = $ticket;
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject('Ответ на ваше обращение')
            ->view('mail.tickets.answer');
    }
}
