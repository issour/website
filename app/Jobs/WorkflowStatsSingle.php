<?php

namespace App\Jobs;

use App\Workflow;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WorkflowStatsSingle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $workflow;

    public function __construct($workflow)
    {
        $this->workflow = $workflow;
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

        $results = $this->githubRequest($this->workflow->repository);

        $this->workflow->update([
            'stars' => Arr::get($results, 'stargazers_count', 0),
            'issues' => Arr::get($results, 'open_issues', 0),
        ]);
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
