<?php

namespace App\Observers;

use Illuminate\Mail\Markdown;
use App\Jobs\Github\RepositoryToModel;

class WorkflowObserver
{
    public function created($workflow)
    {
        $workflow->storeImport();

        dispatch(new RepositoryToModel($workflow->repository, $workflow, [
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
