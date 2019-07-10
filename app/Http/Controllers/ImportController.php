<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function show($id)
    {
        $workflow = Workflow::findOrFail($id);

        return file_get_contents($workflow->path('import.json'));
    }
}
