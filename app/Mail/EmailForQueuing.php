<?php

namespace PacketPrep\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PacketPrep\Models\Mailer\MailLog;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailForQueuing extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    public $subject;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subject,$content)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       if($this->user['maillog']){
            $m = MailLog::where('id',$this->user['maillog'])->first();
            $m->status = 1;
            $m->save();
       }
       return $this->from('no-reply@xplore.co.in', 'Xplore')
            ->subject($this->subject)
            ->view('mail.email')->with('user',$this->user)->with('content',$this->content);
    }
}
