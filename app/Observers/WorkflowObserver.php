<?php

namespace App\Observers;

use Illuminate\Mail\Markdown;
use App\Jobs\WorkflowStatsSingle;

class WorkflowObserver
{
    public function created($workflow)
    {
        $workflow->storeImport();

        dispatch(new WorkflowStatsSingle($workflow));
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
