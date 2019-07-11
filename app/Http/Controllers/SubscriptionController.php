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
            'email' => 'required|email'
        ]);

        if ($request->has('workflow_id')) {
            Workflow::findOrFail($request->workflow_id);
        }

        $subscription = Subscription::firstOrCreate(
            $request->only(['email', 'workflow_id'])
        );

        return redirect()->back()->with('status', 'success');
    }
}
