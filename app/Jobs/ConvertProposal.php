<?php

namespace App\Jobs;

use App\Workflow;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ConvertProposal implements ShouldQueue
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
        Workflow::create([
            'title' => $this->proposal->title,
            'slug' => $this->proposal->repository,
            'blurb' => Str::limit($this->proposal->description, 60),
            'description_markdown' => $this->proposal->description,
            'installation_markdown' => 'This integration is still in progress',
            'repository' => $this->proposal->repository,
            'drafted_at' => now(),
            'app_id' => $this->proposal->app_id,
            'icon' => 'https://placehold.it/24x24&text=coming-soon',
            'image' => 'https://placehold.it/300x250&text=coming-soon',
            'banner' => 'https://placehold.it/900x350&text=coming-soon',
        ]);
    }
}
