<?php

namespace App\Http\Controllers;

use App\WorkflowRequest;
use Illuminate\Http\Request;

class WorkflowRequestController extends Controller
{
    public function create()
    {
        return view('workflow-requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','min:10','max:60'],
            'description' => ['required','min:20','max:500'],
            'url' => ['required','url'],
        ]);

        WorkflowRequest::create(
            $request->only(['title', 'description', 'url'])
        );

        return back()->with(['status' => 'success']);
    }
}
