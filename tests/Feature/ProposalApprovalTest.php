<?php

namespace Tests\Feature;

use App\App;
use App\Proposal;
use App\Workflow;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\Jobs\ApproveProposal;
use App\Jobs\DeleteWorkflowCleanup;
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
        $this->assertEquals('draft', Workflow::staging()->first()->status);
    }
}
