<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowsTest extends TestCase
{
    use RefreshDatabase;

    public function testViewingRecentWorflows()
    {
        factory(Workflow::class, 30)->create();

        $response = $this->get('/workflows');

        $response->assertStatus(200);
        $response->assertSee(Workflow::latest()->first()->title);
    }

    public function testViewingSingleWorflow()
    {
        $workflow = factory(Workflow::class)->create();

        $response = $this->get('/workflows/' . $workflow->id);

        $response->assertStatus(200);
        $response->assertSee(Workflow::first()->title);
        $response->assertSee(Workflow::first()->description);
    }

    public function testSearchingWorflow()
    {
        $workflow = factory(Workflow::class)->create();

        $response = $this->get('/workflows/?search=' . $workflow->title);

        $response->assertStatus(200);
        $response->assertSee(Workflow::first()->title);

        $response = $this->get('/workflows/?search=somerandomness');

        $response->assertStatus(200);
        $response->assertSee("No workflows found");
    }
}