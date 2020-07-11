<?php

namespace PacketPrep\Jobs;

use PacketPrep\Models\Exam\Tests_Section;
use PacketPrep\Models\Exam\Tests;
use PacketPrep\Models\Exam\Tests_Overall;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAttempts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $secs;
    protected $test_overall;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$secs,$test_overall)
    {
        $this->data = $data;
        $this->secs = $secs;
        $this->test_overall = $test_overall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tests::insert($this->data);
        Tests_Section::insert($this->secs);
        Tests_Overall::insert($this->test_overall);
    }
}
