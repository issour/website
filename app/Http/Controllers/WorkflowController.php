<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        return view('workflows.index', [
            'workflows' => Workflow::filtered()->published()->paginate(20)
        ]);
    }

    public function show($slug)
    {
        $workflow = Workflow::bySlug($slug);

        return view('workflows.show', [
            'workflow' => $workflow,
            'recipes' => $workflow->recipes,
            'vote' => optional(auth()->user())->voteFor($workflow),
        ]);
    }
}
