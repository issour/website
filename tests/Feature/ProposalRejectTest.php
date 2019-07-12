<?php

namespace Tests\Feature;

use App\Proposal;
use Tests\TestCase;
use App\Jobs\RejectProposal;
use App\Notifications\ProposalRejection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProposalRejectTest extends TestCase
{
    use RefreshDatabase;

    public function testCantRejectRejectedProposals()
    {
        $this->expectExceptionMessage('Proposal already rejected');
        $proposal = factory(Proposal::class)->state('rejected')->create();
        dispatch(new RejectProposal($proposal));
    }

    public function testCanRejectApprovedProposals()
    {
        $proposal = factory(Proposal::class)->state('approved')->create();
        dispatch(new RejectProposal($proposal));
        tap($proposal->fresh(), function ($proposal) {
            $this->assertNull($proposal->approved_at);
            $this->assertNotNull($proposal->rejected_at);
        });
    }

    public function testQuitelyRejectProposalsWithoutEmail()
    {
        Notification::fake();
        $proposal = factory(Proposal::class)->create();
        dispatch(new RejectProposal($proposal));
        Notification::assertNothingSent();
        $this->assertNotNull($proposal->fresh()->rejected_at);
    }

    public function testNotifyRejectedProposalsWithEmail()
    {
        Notification::fake();
        $proposal = factory(Proposal::class)->state('with-email')->create();
        dispatch(new RejectProposal($proposal));
        Notification::assertSentTo(
            $proposal,
            ProposalRejection::class,
            function ($notification, $channels) use ($proposal) {
                return $notification->proposal->id === $proposal->id;
            }
        );

        $this->assertNotNull($proposal->fresh()->rejected_at);
    }
}
