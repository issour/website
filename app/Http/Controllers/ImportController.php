<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function show($id)
    {
        if (Storage::exists("workflows/$id.json")) {
            return Storage::get("workflows/$id.json");
        }

        return [];
    }
}
