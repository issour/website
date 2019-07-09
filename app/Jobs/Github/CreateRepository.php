<?php

namespace App\Jobs\Github;

use GuzzleHttp\Client;
use App\Jobs\FillRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $repository;
    public $owner;
    public $token;

    public function __construct($repository)
    {
        $this->repository = $repository;
        $this->owner = config('services.github.owner');
        $this->token = config('services.github.token');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(Client::class)->request('POST', $this->endpoint(), [
            'json' => [
                'name' => $this->repository,
                'description' => str_replace('-', ' ', ucwords($this->repository)) . ' with Laravel',
                'homepage' => "https://novaworkflows.com/workflows/{$this->repository}",
                'private' => false,
                'has_projects' => false,
                'has_wiki' => false,
            ]
        ]);
    }

    protected function endpoint()
    {
        return "https://api.github.com/orgs/{$this->owner}/repos?access_token={$this->token}";
    }
}
