<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function getPolicies()
    {
        $policies = Policy::all();

        return response()->json($policies);
    }

    public function editPolicyPeriod(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);
        $period = $request->input('period');

        if ($period <= 0) {
            return response()->json(['error' => 'Policy period cannot be 0 or negative'], 400);
        }

        $policy->update(['period' => $period]);

        return response()->json($policy);
    }
}
