<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Workflow;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store($workflowId)
    {
        $workflow = Workflow::findOrFail($workflowId);

        if ($workflow->inStaging()) {
            $vote = Vote::firstOrCreate([
                'workflow_id' => $workflow->id,
                'user_id' => auth()->user()->id,
            ]);
        }

        return redirect()->route('workflows.show', $workflow->slug);
    }
}
