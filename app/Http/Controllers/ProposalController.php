<?php

namespace App\Http\Controllers;

use App\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function create()
    {
        return view('proposals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:10|max:60',
            'description' => 'required|min:20|max:500',
            'url' => 'required|url',
            'email' => 'nullable|email',
        ]);

        Proposal::create(
            $request->only(['title', 'description', 'url'])
        );

        return back()->with(['status' => 'success']);
    }
}
