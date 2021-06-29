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
        $this->withSwiftMessage(function ($message) {
            $m = MailLog::where('id',$this->user['maillog'])->first();
            $m->message_id = $message->getId();
            $m->status = 1;
            $m->save();
            
        });
      
      if(domain()=='xplore')
       return $this->from('no-reply@xplore.co.in', 'Xplore')
            ->subject($this->subject)
            ->view('mail.email')->with('user',$this->user)->with('content',$this->content);
        else
            return $this->from('no-reply@mail.packetprep.com', 'PacketPrep')
            ->subject($this->subject)
            ->view('mail.emailpp')->with('user',$this->user)->with('content',$this->content);

    }
}
