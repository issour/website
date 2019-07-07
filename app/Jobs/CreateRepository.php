<?php

namespace App\Jobs;

use App\Proposal;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $proposal;

    public $fields;

    public function __construct(Proposal $proposal, array $fields)
    {
        $this->proposal = $proposal;

        $this->fields = $fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $owner = config('services.github.owner');
        $token = config('services.github.token');
        $repository = $this->fields['repository'];

        app(Client::class)->request('POST', "https://api.github.com/orgs/$owner/repos?access_token=$token", [
            'json' => [
                'name' => $this->fields['repository'],
                'description' => 'Laravel Nova: ' . str_replace('-', ' ', ucwords($repository)),
                'homepage' => "https://novaworkflows.com/workflows/$repository",
                'private' => false,
                'has_projects' => false,
                'has_wiki' => false,
            ]
        ]);
    }
}
