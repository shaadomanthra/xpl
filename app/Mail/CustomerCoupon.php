<?php

namespace PacketPrep\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerCoupon extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $customer;
     /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$customer)
    {
         $this->user = $user;
         $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->user->name.' - User Coupon - '.$this->customer->company)->markdown('mail.customercoupon');
    }
}
