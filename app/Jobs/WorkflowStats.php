<?php

namespace App\Jobs;

use App\Workflow;
use Illuminate\Bus\Queueable;
use App\Jobs\Github\ModelRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WorkflowStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (app()->environment('testing')) {
            return;
        }

        Workflow::each(function ($workflow) {
            dispatch(new ModelRepository($workflow, $workflow->repository, [
                'stars' => 'stargazers_count',
                'issues' => 'open_issues',
            ]));
        });
    }
}
