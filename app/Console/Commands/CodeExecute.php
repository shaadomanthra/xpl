<?php

namespace PacketPrep\Console\Commands;

use Illuminate\Console\Command;
use PacketPrep\Models\Exam\Exam;

class CodeExecute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the open commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return (new Exam)->runCode();
    }
}
