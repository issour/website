<?php

namespace App\Jobs\Github;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TagRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $repository;
    public $topics;
    public $owner;
    public $token;

    public function __construct($repository, array $topics)
    {
        $this->repository = $repository;
        $this->topics = $topics;
        $this->owner = config('services.github.owner');
        $this->token = config('services.github.token');
    }

    public function handle()
    {
        app(Client::class)->request('PUT', $this->endpoint(), [
            'headers' => ['Accept' => 'application/vnd.github.mercy-preview+json'],
            'json' => [
                'names' => $this->topics,
            ],
        ]);
    }

    protected function endpoint()
    {
        return "https://api.github.com/repos/{$this->owner}/{$this->repository}/topics?access_token={$this->token}";
    }
}
