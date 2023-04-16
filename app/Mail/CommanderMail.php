<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommanderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qte;
    public $medicament;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($qte,$medicament)
    {
        $this->qte = $qte;
        $this->medicament = $medicament;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('WebPharm');

        return $this->view('CommanderMail.commanderMail');
    }
}
