<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use App\Subscription;
use App\Jobs\LaunchWorkflow;
use App\Notifications\WorkflowLaunch;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowLaunchTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotLaunchLiveWorkflows()
    {
        $this->expectExceptionMessage('Cannot launch a published workflow');

        $workflow = factory(Workflow::class)->state('live')->create();

        dispatch(new LaunchWorkflow($workflow));
    }

    public function testCanLaunchStaggedWorkflows()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        dispatch(new LaunchWorkflow($workflow));

        tap($workflow->fresh(), function ($workflow) {
            $this->assertTrue($workflow->isPublished());
            $this->assertFalse($workflow->inStaging());
        });
    }

    public function testLaunchNotifiesSubscribers()
    {
        Notification::fake();

        $workflow = factory(Workflow::class)->state('staging')->create();

        factory(Subscription::class, 10)->create(['workflow_id' => $workflow->id]);

        dispatch(new LaunchWorkflow($workflow));

        Notification::assertSentTo(
            $workflow->subscribers,
            WorkflowLaunch::class,
            function ($notification, $channels) use ($workflow) {
                return $notification->workflow->id === $workflow->id;
            }
        );
    }
}
