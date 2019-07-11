<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use App\Jobs\LaunchWorkflow;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowLaunchTest extends TestCase
{
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
}
