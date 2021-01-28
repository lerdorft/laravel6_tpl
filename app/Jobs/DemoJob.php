<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class DemoJob extends Job
{
    /**
     * @var int id
     */
    protected $id;

    /**
     * DemoJob constructor.
     *
     * @param int $id
     */
    public function __construct($id)
    {
        Log::info('demo set, id:' . $id);
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('demo job execute, id:' . $this->id);

        echo $this->id;
    }
}
