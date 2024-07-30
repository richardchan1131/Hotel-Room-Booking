<?php

namespace Pro\Support\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Pro\Support\Models\Ticket;
use Pro\Support\Models\TicketReply;

class TicketHasNewReplyEmail extends \Illuminate\Mail\Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $ticket;
    protected $reply;
    protected $email_to;

    public function __construct(Ticket $ticket, TicketReply $reply, $to = 'customer')
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
        $this->email_to = $to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'to'     => $this->email_to,
            'ticket' => $this->ticket,
            'reply'  => $this->reply,
        ];
        return $this->subject(__("New reply on ticket: #" . $this->ticket->id))->view('Support::email.new_reply', $data);
    }
}
