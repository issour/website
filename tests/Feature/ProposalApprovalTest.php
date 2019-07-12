<?php

namespace Tests\Feature;

use App\App;
use App\Proposal;
use App\Workflow;
use Tests\TestCase;
use App\Subscription;
use GuzzleHttp\Client;
use App\Jobs\ApproveProposal;
use App\Jobs\DeleteWorkflowCleanup;
use App\Notifications\ProposalApproval;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProposalApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function testCantApproveApprovedProposals()
    {
        $this->expectExceptionMessage('Proposal already approved');
        $proposal = factory(Proposal::class)->state('approved')->create();
        dispatch(new ApproveProposal($proposal));
    }

    public function testCantApproveProposalWithoutApp()
    {
        $this->expectExceptionMessage('Proposal approval requires app');
        $proposal = factory(Proposal::class)->create();
        dispatch(new ApproveProposal($proposal));
    }

    public function testCanApproveRejectedProposals()
    {
        $this->mock(Client::class, function ($mock) {
            $mock->shouldReceive('request');
        });

        $proposal = factory(Proposal::class)->states('rejected', 'action-fields')->create();
        dispatch(new ApproveProposal($proposal));

        tap($proposal->fresh(), function ($proposal) {
            $this->assertNotNull($proposal->approved_at);
            $this->assertNull($proposal->rejected_at);
        });
    }

    public function testApprovingProposals()
    {
        $proposal = factory(Proposal::class)->state('with-logo')->create([
            'repository' => 'some-repo-name' . rand(500, 1000),
            'stub' => 'stubs/outcome',
            'app_id' => factory(App::class),
        ]);

        $this->mock(Client::class, function ($mock) {
            $mock->shouldReceive('request');
        });

        dispatch(new ApproveProposal($proposal));

        $this->assertEquals(1, Workflow::staging()->count());
        $this->assertEquals('staging', Workflow::staging()->first()->status);
    }

    public function testApprovedProposalCreatesSubscriber()
    {
        $this->mock(Client::class, function ($mock) {
            $mock->shouldReceive('request');
        });

        $proposal = factory(Proposal::class)->states('action-fields', 'with-email')->create();

        dispatch(new ApproveProposal($proposal));

        $this->assertEquals(1, Subscription::count());
        $this->assertEquals($proposal->email, Subscription::first()->email);
    }

    public function testApprovalSendsNotification()
    {
        Notification::fake();

        $proposal = factory(Proposal::class)->state('with-logo')->create([
            'repository' => 'some-repo-name' . rand(500, 1000),
            'stub' => 'stubs/outcome',
            'app_id' => factory(App::class),
        ]);

        $this->mock(Client::class, function ($mock) {
            $mock->shouldReceive('request');
        });

        dispatch(new ApproveProposal($proposal));

        Notification::assertSentTo(
            $proposal,
            ProposalApproval::class,
            function ($notification, $channels) use ($proposal) {
                return $notification->proposal->id === $proposal->id;
            }
        );
    }
}
