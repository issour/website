<?php

namespace App\Jobs\Github;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ModelRepository implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public $repository;
    public $bindings;

    public function __construct($model, $repository, $bindings)
    {
        $this->model = $model;
        $this->repository = $repository;
        $this->bindings = $bindings;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (app()->environment(['testing', 'seeding'])) {
            return;
        }

        $values = [];

        $results = $this->githubRequest($this->repository);

        foreach ($this->bindings as $property => $githubKey) {
            $values[$property] = Arr::get($results, $githubKey, 0);
        }

        $this->model->update($values);
    }

    protected function githubRequest($repository)
    {
        $owner = config('services.github.owner');

        $response = app(Client::class)->request('GET', "https://api.github.com/repos/$owner/$repository", [
            'stream_context' =>  ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]],
            'stream' => true,
        ]);

        if ($response) {
            return json_decode($response->getBody(), true);
        }

        return [];
    }
}
