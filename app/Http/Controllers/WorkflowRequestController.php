<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkflowRequestController extends Controller
{
    public function create()
    {
        return view('workflow-requests.create');
    }

    public function store()
    {
        //
    }
}
