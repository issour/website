<?php

namespace App\Observers;

class WorkflowObserver
{
    public function created($workflow)
    {
        $workflow->updateGithubData();
    }
}
