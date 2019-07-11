<?php

namespace Tests\Feature;

use App\User;
use App\Vote;
use App\Workflow;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoteTest extends TestCase
{
    use RefreshDatabase;

    public function testVisitorsSeeCallToActionWithLoginOnStaging()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->get("workflows/{$workflow->slug}")
            ->assertStatus(200)
            ->assertSee('You must be logged in to vote:')
            ->assertSee('Login with Github')
            ->assertDontSee('Click below to vote:');
    }

    public function testVisitorsDontSeeCallToActionOnLive()
    {
        $workflow = factory(Workflow::class)->state('live')->create();

        $this->get("workflows/{$workflow->slug}")
            ->assertStatus(200)
            ->assertDontSee('You must be logged in to vote:')
            ->assertDontSee('Login with Github');
    }

    public function testAuthUsersSeeVoteOptionOnStaging()
    {
        $this->be(factory(User::class)->create());

        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->get("workflows/{$workflow->slug}")
            ->assertStatus(200)
            ->assertSee('Click below to vote:')
            ->assertDontSee('Login with Github');
    }

    public function testVistorSubmitVoteRedirectsToLogin()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->post("votes/{$workflow->id}")
            ->assertRedirect(route('login'));
    }

    public function testAuthUserSubmitVoteToLiveWorkflowRedirectsBack()
    {
        $this->be(factory(User::class)->create());

        $workflow = factory(Workflow::class)->state('live')->create();

        $this->post("votes/{$workflow->id}")
            ->assertRedirect("workflows/{$workflow->slug}");
    }

    public function testAuthUserSubmitVoteIncreasesCount()
    {
        $this->be(factory(User::class)->create());

        $workflow = factory(Workflow::class)->state('staging')->create();

        $response = $this->post("votes/{$workflow->id}");

        $this->assertEquals(1, Vote::count());

        tap($workflow->fresh(), function ($workflow) {
            $this->assertEquals(1, $workflow->votes);
        });
    }

    public function testAuthUserVotingTwiceIncreasesCountOneTime()
    {
        $this->be(factory(User::class)->create());

        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->post("votes/{$workflow->id}");
        $this->post("votes/{$workflow->id}");

        $this->assertEquals(1, Vote::count());

        tap($workflow->fresh(), function ($workflow) {
            $this->assertEquals(1, $workflow->votes);
        });
    }

    public function testVotingHidesTheAbilityToVoteAgain()
    {
        $this->be(factory(User::class)->create());

        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->post("votes/{$workflow->id}");

        $this->get("workflows/{$workflow->slug}")
            ->assertSee('You voted on: '. Vote::first()->created_at->format('m/d/Y'))
            ->assertDontSee('Click below to vote:')
            ->assertDontSee('Login with Github');
    }

    public function testRelationships()
    {
        $user = factory(User::class)->create();
        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->be($user);
        $this->post("votes/{$workflow->id}");

        $this->assertTrue($user->votes->contains($workflow)) ;
        $this->assertTrue($workflow->voters->contains($user));
    }
}
