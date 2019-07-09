<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowsTest extends TestCase
{
    use RefreshDatabase;

    public function testLiveScope()
    {
        factory(Workflow::class, 2)->state('live')->create();
        factory(Workflow::class, 2)->state('staging')->create();

        $this->assertEquals(2, Workflow::count());
    }

    public function testViewingRecentWorkflows()
    {
        factory(Workflow::class, 30)->state('live')->create();

        $response = $this->get('/workflows');

        $response->assertStatus(200);
        $response->assertSee(Workflow::latest()->first()->title);
    }

    public function testViewingSingleWorkflow()
    {
        $workflow = factory(Workflow::class)->state('live')->create();

        $response = $this->get('/workflows/' . $workflow->slug);

        $response->assertStatus(200);
        $response->assertSee($workflow->title);
        $response->assertSee($workflow->description);
    }

    public function testSearchingWorkflow()
    {
        $workflow = factory(Workflow::class)->create();

        $response = $this->get('/workflows/?search=' . $workflow->title);

        $response->assertStatus(200);
        $response->assertSee($workflow->title);

        $response = $this->get('/workflows/?search=somerandomness');

        $response->assertStatus(200);
        $response->assertSee("No workflows found");
    }

    public function testStoringImportsOfWorkflows()
    {
        $workflow = factory(Workflow::class)->create();

        $response = $this->json('GET', "import/workflows/{$workflow->id}.json");

        $response
            ->assertStatus(200)
            ->assertJson([
                'title' => $workflow->title,
                'outcome' => $workflow->outcome,
                'options' => $workflow->options,
            ]);
    }
}
