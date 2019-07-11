<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use App\Subscription;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testSeeSubscriptionFormOnStagingWorkflow()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();
        $response = $this->get("workflows/$workflow->slug");
        $response->assertSee('Get notified when launched');
    }

    public function testDontSeeSubscriptionFormOnLiveWorkflow()
    {
        $workflow = factory(Workflow::class)->state('live')->create();
        $response = $this->get("workflows/$workflow->slug");
        $response->assertDontSee('Get notified when launched');
    }

    public function testSubmittingRequiresEmail()
    {
        $response = $this->post("subscribe", []);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);
    }

    public function testSubmittingRejectsInvalidEmail()
    {
        $response = $this->post("subscribe", [
            'email' => 'nope'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
        ]);
    }

    public function testSubmittingValidEmailSubscribes()
    {
        $response = $this->from('/workflows')->post("subscribe", [
            'email' => 'valid@example.com'
        ]);

        $this->assertEquals(1, Subscription::count());
        $response->assertRedirect('/workflows');
        $response->assertSessionHas('status', 'success');
    }

    public function testSubmittingSameEmailDoesNotSubscribeForGeneral()
    {
        $this->post("subscribe", [
            'email' => 'valid@example.com'
        ]);

        $response = $this->from('/workflows')->post("subscribe", [
            'email' => 'valid@example.com'
        ]);

        $this->assertEquals(1, Subscription::count());
        $response->assertRedirect('/workflows');
        $response->assertSessionHas('status', 'success');
    }

    public function testSubscribingToWorkflowInStaging()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        $response = $this->from("workflows/$workflow->slug")->post("subscribe", [
            'email' => 'valid@example.com',
            'workflow_id' => $workflow->id,
        ]);

        $this->assertEquals(1, Subscription::count());
        $this->assertEquals($workflow->id, Subscription::first()->workflow->id);
        $this->assertCount(1, $workflow->subscriptions);
        $this->assertEquals(Subscription::first()->id, $workflow->subscriptions->first()->id);

        $response->assertRedirect("workflows/$workflow->slug");
        $response->assertSessionHas('status', 'success');
    }

    public function testCannotSubscribeToMissingWorkflow()
    {
        $response = $this->post("subscribe", [
            'email' => 'valid@example.com',
            'workflow_id' => '4342',
        ]);

        $response->assertNotFound();

        $this->assertEquals(0, Subscription::count());
    }

    public function testCanSubscribeToGeneralAndWorkflow()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        $this->post("subscribe", [
            'email' => 'valid@example.com',
        ]);

        $this->post("subscribe", [
            'email' => 'valid@example.com',
            'workflow_id' => $workflow->id,
        ]);

        $this->assertEquals(2, Subscription::count());
        $this->assertEquals(1, Subscription::general()->count());
        $this->assertEquals(1, Subscription::workflows()->count());
    }
}
