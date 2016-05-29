<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Services\Logger\Warehouse;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLogToWarehouse extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /** @var string $exec command to shell exec */
    public $exec;

    /**
     * SendLogToWarehouse constructor.
     *
     * @param string $exec command to shell exec
     */
    public function __construct($exec)
    {
        $this->exec = $exec;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        shell_exec($this->exec);
    }
}
