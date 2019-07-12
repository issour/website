<?php

namespace Tests\Feature;

use App\App;
use App\Proposal;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\Jobs\Github\FillRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FillRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $app = factory(App::class)->create(['title' => 'Quickbooks']);

        $proposal = factory(Proposal::class)->state('action-fields')->create([
            'title' => 'Create Quickbooks invoice',
            'repository' => 'create-quickbooks-invoice',
            'app_id' => $app->id,
        ]);

        $this->mock(\GuzzleHttp\Client::class, function ($mock) {
            $mock->shouldReceive('request');
        });

        $variables = (new FillRepository($proposal->repository, '/', $proposal->load('app')->toArray()))->variables();

        $this->assertEquals([
            'app' => 'Quickbooks',
            'class' =>  'CreateQuickbooksInvoice',
            'name' => 'Create Quickbooks Invoice',
            'repository' => 'create-quickbooks-invoice',
            'owner' => 'nova-workflows',
            'link' => 'https://novaworkflows.com/workflows/create-quickbooks-invoice',
        ], $variables);
    }
}
