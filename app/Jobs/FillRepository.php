<?php

namespace App\Jobs;

use Stub\Stub;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FillRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $folder;
    public $variables;
    public $repository;
    public $owner;
    public $token;

    public function __construct($repository, $folder, $variables = [])
    {
        $this->folder = $folder;
        $this->variables = $variables;
        $this->repository = $repository;

        $this->owner = config('services.github.owner');
        $this->token = config('services.github.token');
    }

    public function handle()
    {
        Stub::source($this->folder)->output(function ($path, $content) {
            app(Client::class)->request('PUT', $this->endpoint($path), [
                'json' => [
                    'committer' => config('services.github.author'),
                    'message' => 'Add ' . Arr::last(explode('/', $path)),
                    'content' => base64_encode($content),
                ]
            ]);
        })->parse($this->variables);
    }

    protected function endpoint($path)
    {
        return "https://api.github.com/repos/{$this->owner}/{$this->repository}/contents/$path?access_token={$this->token}";
    }
}
