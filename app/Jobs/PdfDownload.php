<?php

namespace PacketPrep\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PdfDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 20;
    protected $slug;
    protected $student;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($slug,$student)
    {
        $this->slug = $slug;
        $this->student = $student;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app('PacketPrep\Http\Controllers\Exam\AssessmentController')->responses($this->slug,null,$this->student,1,request());
    }
}
