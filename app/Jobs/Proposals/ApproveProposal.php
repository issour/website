<?php

namespace App\Jobs\Proposals;

use App\Workflow;
use Illuminate\Bus\Queueable;
use App\Jobs\Github\TagRepository;
use App\Jobs\Github\FillRepository;
use App\Jobs\Github\CreateRepository;
use App\Jobs\Workflows\GenerateImages;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Proposals\ConvertProposal;
use App\Notifications\ProposalApproval;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\Proposals\ApprovalNotification;

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
        abort_if(!is_null($this->proposal->approved_at), 500, 'Proposal already approved');

        abort_if(is_null($this->proposal->app), 500, 'Proposal approval requires app');

        $this->proposal->update([
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        $repository = $this->proposal->repository;

        $this->chain([
            new CreateRepository($repository),
            new ConvertProposal($this->proposal),
            new GenerateImages($repository),
            new TagRepository($repository, $this->topics()),
            new FillRepository(
                $repository,
                resource_path($this->proposal->stub),
                $this->proposal->toArray()
            ),
            new ApprovalNotification($this->proposal),
        ]);
    }

    public function topics()
    {
        return ['laravel', strtolower($this->proposal->app->title), 'laravel-nova'];
    }
}
