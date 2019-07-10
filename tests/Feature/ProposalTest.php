<?php

namespace Tests\Feature;

use App\App;
use App\Proposal;
use App\Workflow;
use Tests\TestCase;
use GuzzleHttp\Client;
use App\Jobs\ApproveProposal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProposalTest extends TestCase
{
    use RefreshDatabase;

    public function testViewingRequestForm()
    {
        $response = $this->get('/new');

        $response
            ->assertStatus(200)
            ->assertSee('Request a workflow');
    }

    public function testCannotSubmitEmptyForm()
    {
        $response = $this->post('/new', []);

        $response->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'url' => 'The url field is required.',
            'description' => 'The description field is required.'
        ]);
    }

    public function testCannotSubmitTooShort()
    {
        $response = $this->post('/new', [
            'title' => 'Hi',
            'description' => 'Hello',
        ]);

        $response->assertSessionHasErrors([
            'title' => 'The title must be at least 10 characters.',
            'description' => 'The description must be at least 20 characters.',
        ]);
    }

    public function testCannotSubmitTooLong()
    {
        $response = $this->post('/new', [
            'title' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent at feugiat ante, ac pellentesque nisl. Sed sed lacus et magna congue convallis feugiat id ante. Integer a urna tellus.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent at feugiat ante, ac pellentesque nisl. Sed sed lacus et magna congue convallis feugiat id ante. Integer a urna tellus. Morbi scelerisque tincidunt diam, eu mattis augue consectetur in. Nunc laoreet egestas lacus id mattis. Nam at est nec leo placerat euismod. Vivamus ut convallis dui. Vivamus interdum justo mattis consectetur euismod. Integer elit turpis, feugiat non lectus ut, consectetur interdum lectus. Nunc non dictum felis, sit amet blandit risus. Praesent sodales, lorem ac pretium vulputate, tortor urna aliquet lorem, sit amet gravida magna justo eu neque. Vestibulum vitae porttitor mauris. Cras faucibus, metus et volutpat interdum, dui elit dignissim nibh, id efficitur leo ipsum at lectus. Sed nunc nibh, dapibus tempor consectetur at, gravida ut dolor. Morbi a nunc eu urna iaculis hendrerit. Morbi sed justo et ipsum imperdiet porttitor malesuada sed orci. Aliquam erat volutpat. Curabitur ullamcorper, quam et consequat dapibus, lacus orci sollicitudin lectus, a molestie urna nisi eget odio. Nullam nec magna arcu. Sed ultrices nisl at leo aliquet, et laoreet nulla laoreet. Proin tempor magna eget velit sollicitudin, sed congue est bibendum.',
        ]);

        $response->assertSessionHasErrors([
            'title' => 'The title may not be greater than 60 characters.',
            'description' => 'The description may not be greater than 500 characters.',
        ]);
    }

    public function testCannotSubmitInvalidUrl()
    {
        $response = $this->post('/new', [
            'url' => 'example',
        ]);

        $response->assertSessionHasErrors([
            'url' => 'The url format is invalid.',
        ]);
    }

    public function testSubmittingValidRequestCreatesRequest()
    {
        $response = $this->post('/new', [
            'title' => 'Send Gmail Message',
            'description' => 'It would be useful if we could send email through gmail',
            'url' => 'https://gmail.com',
        ]);

        $response->assertSessionHas('status', 'success');

        $requests = Proposal::all();

        $this->assertCount(1, $requests);
        $this->assertEquals('Send Gmail Message', $requests[0]->title);
        $this->assertEquals('It would be useful if we could send email through gmail', $requests[0]->description);
        $this->assertEquals('https://gmail.com', $requests[0]->url);
    }
}
