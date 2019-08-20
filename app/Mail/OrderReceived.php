<?php

namespace App\Mail;

use App\User;
use App\OrderSummary;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $summary;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, OrderSummary $summary)
    {
        $this->user = $user;
        $this->summary = $summary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order_received');
    }
}
