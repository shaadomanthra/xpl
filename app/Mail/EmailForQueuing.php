<?php

namespace PacketPrep\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       return $this->from('no-reply@xplore.co.in', 'Xplore')
            ->subject('Apply for [24]7Ai Job Opening')
            ->view('mail.email')->with('user',$this->user);
    }
}
