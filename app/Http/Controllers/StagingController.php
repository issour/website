<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;

class StagingController extends Controller
{
    public function index()
    {
        return view('staging.index', [
            'workflows' => Workflow::staging()->filtered()->paginate(20)
        ]);
    }
}
