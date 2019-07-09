<?php

namespace App\Jobs\Github;

use App\model;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RepositoryToModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $repository;
    public $model;
    public $bindings;

    public function __construct($repository, $model, $bindings)
    {
        $this->repository = $repository;
        $this->model = $model;
        $this->bindings = $bindings;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (app()->environment('testing')) {
            return;
        }

        $values = [];

        $results = $this->githubRequest($this->repository);

        foreach ($this->bindings as $mKey => $ghKey) {
            $values[$mKey] = Arr::get($results, $ghKey, 0);
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
