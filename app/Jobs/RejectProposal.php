<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\ProposalRejection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RejectProposal implements ShouldQueue
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
        abort_if(!is_null($this->proposal->rejected_at), 500, 'Proposal already rejected');

        $this->proposal->update(['rejected_at' => now(), 'approved_at' => null]);

        if ($this->proposal->email) {
            $this->proposal->notify(new ProposalRejection($this->proposal));
        }
    }
}
