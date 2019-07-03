<?php

namespace Tests\Feature;

use App\Workflow;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanSearchAppOnWorkflows()
    {
        $workflows = factory(Workflow::class, 2)->create();

        $response = $this->get('/workflows?search='.$workflows->first()->app->title);

        $response->assertStatus(200);

        $response->assertViewHas('workflows', function ($results) use ($workflows) {
            return $results->contains($workflows->first()) && ! $results->contains($workflows->last());
        });
    }
}
