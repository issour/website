<?php

namespace App\Observers;

use Illuminate\Mail\Markdown;
use App\Jobs\Github\ModelRepository;

class WorkflowObserver
{
    public function creating($workflow)
    {
        if (!file_exists($workflow->path())) {
            mkdir($workflow->path());
        }
    }

    public function created($workflow)
    {
        $workflow->storeImport();

        dispatch(new ModelRepository($workflow, $workflow->repository, [
            'stars' => 'stargazers_count',
            'issues' => 'open_issues',
        ]));
    }

    public function saving($workflow)
    {
        $workflow->description = Markdown::parse($workflow->description_markdown);
        $workflow->installation = Markdown::parse($workflow->installation_markdown);
    }

    public function saved($workflow)
    {
        if ($workflow->wasChanged(['outcome', 'options'])) {
            $workflow->storeImport();
        }
    }
}
