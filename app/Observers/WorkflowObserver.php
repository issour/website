<?php

namespace App\Observers;

use Illuminate\Mail\Markdown;

class WorkflowObserver
{
    public function created($workflow)
    {
        $workflow->storeImport();
        $workflow->updateGithubData();
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
