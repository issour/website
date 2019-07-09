<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StagingTest extends TestCase
{
    use RefreshDatabase;

    public function testStagingScope()
    {
        factory(Workflow::class, 2)->state('live')->create();
        factory(Workflow::class, 2)->state('staging')->create();

        $this->assertEquals(2, Workflow::staging()->count());
    }

    public function testViewingStagingIndex()
    {
        $live = factory(Workflow::class, 2)->state('live')->create();
        $staging = factory(Workflow::class, 2)->state('staging')->create();

        $response = $this->get('/staging');

        $response->assertStatus(200);

        $response->assertViewHas('workflows', function ($workflows) {
            return $workflows->count() == 2;
        });

        $response->assertSeeInOrder(
            $staging->pluck('title')->toArray()
        );
    }

    public function testViewingSingleStagedWorkflow()
    {
        $workflow = factory(Workflow::class)->state('staging')->create();

        $response = $this->get('/workflows/' . $workflow->slug);

        $response->assertStatus(200);
        $response->assertSee($workflow->title);
        $response->assertSee($workflow->description);
        $response->assertSee('Staging');
    }
}
