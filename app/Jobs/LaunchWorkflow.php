<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Jobs\NotifyLaunchSubscribers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LaunchWorkflow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $workflow;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        abort_if($this->workflow->isPublished(), 500, 'Cannot launch a published workflow');

        $this->workflow->update([
            'published_at' => now()
        ]);
    }
}
