<?php

namespace PacketPrep\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PacketPrep\Models\Exam\Exam;
use PacketPrep\User;

class writing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $exam;
    public $tries = 5;
    public $timeout = 20;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$exam)
    {
        $this->user = $user;
        $this->exam = $exam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->exam->grammarly($this->user,1);
    }
}
