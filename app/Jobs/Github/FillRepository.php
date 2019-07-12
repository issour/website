<?php

namespace App\Jobs\Github;

use Stub\Stub;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

    public $source;
    public $values;
    public $owner;
    public $token;
    public $repository;

    public function __construct($repository, $source, $values = [])
    {
        $this->source = $source;
        $this->values = $values;
        $this->repository = $repository;
        $this->owner = config('services.github.owner');
        $this->token = config('services.github.token');
    }

    public function handle()
    {
        Stub::source($this->source)->output(function ($path, $content) {
            app(Client::class)->request('PUT', $this->endpoint($path), [
                'json' => [
                    'committer' => config('services.github.author'),
                    'message' => 'Add ' . Arr::last(explode('/', $path)),
                    'content' => base64_encode($content),
                ]
            ]);
        })->parse($this->variables());
    }

    protected function endpoint($path)
    {
        return "https://api.github.com/repos/{$this->owner}/{$this->repository}/contents/$path?access_token={$this->token}";
    }

    public function variables()
    {
        return [
            'app' => Arr::get($this->values, 'app.title'),
            'class' => Str::studly($this->values['title']),
            'name' => Str::title($this->values['title']),
            'repository' => $this->repository,
            'owner' => config('services.github.owner'),
            'link' => 'https://novaworkflows.com/workflows/' . $this->repository,
        ];
    }
}
