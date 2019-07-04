<?php

namespace App\Observers;

class WorkflowObserver
{
    public function created($workflow)
    {
        $workflow->storeImport();
        $workflow->updateGithubData();
    }

    public function saved($workflow)
    {
        if ($workflow->wasChanged(['outcome', 'options'])) {
            $workflow->storeImport();
        }
    }
}
