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
        $validatedData = $request->validate([
            'period' => 'required|integer|min:1',
        ]);

        $policy = Policy::findOrFail($id);
        $period = $validatedData['period'];

        try {
            $policy->update(['period' => $period]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update policy period'], 500);
        }

        return response()->json($policy);
    }
}
