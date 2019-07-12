<?php

namespace App\Http\Controllers;

use App\Workflow;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'workflow_id' => 'nullable|exists:workflows,id'
        ]);

        Subscription::firstOrCreate(
            $request->only(['email', 'workflow_id'])
        );

        return redirect()->back()->with('status', 'success');
    }

    public function edit()
    {
        return view('subscriptions.edit');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        Subscription::where('email', $request->email)->delete();

        return back()->with('status', 'success');
    }
}
