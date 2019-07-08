<?php

namespace App\Jobs;

use App\Workflow;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApproveProposal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $proposal;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->chain([
            new CreateRepository($this->proposal->repository),
            new ConvertProposal($this->proposal),
            new FillRepository(
                $this->proposal->repository,
                resource_path($this->proposal->stub),
                $this->proposal->toArray()
            ),
        ]);
    }
}
