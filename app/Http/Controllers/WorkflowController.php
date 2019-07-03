<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index()
    {
        return view('workflows.index', [
            'workflows' => Workflow::filtered()->paginate(20)
        ]);
    }

    public function show($id)
    {
        return view('workflows.show', [
            'workflow' => Workflow::findOrFail($id)
        ]);
    }
}
