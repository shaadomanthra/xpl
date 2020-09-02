<?php

namespace PacketPrep\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PacketPrep\Mail\EmailForQueuing;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;
    public $timeout = 20;
    protected $details;
    public $subject;
    public $content;

    public function __construct($details,$subject,$content)
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->details['email'])->send(new EmailForQueuing($this->details,$this->subject,$this->content));
    }
}
