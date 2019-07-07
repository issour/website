<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkflowRequestTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testViewingRequestForm()
    {
        $response = $this->get('/new');

        $response
            ->assertStatus(200)
            ->assertSee('Request a workflow');
    }
}
