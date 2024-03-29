<?php

namespace App\Jobs\Proposals;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ProposalApproval;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ApprovalNotification implements ShouldQueue
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
        $this->proposal->notify(new ProposalApproval($this->proposal));
    }
}
