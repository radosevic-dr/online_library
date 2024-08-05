<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPageOptions = [20, 50, 100];

        $validator = Validator::make($request->all(), [
            'per_page' => [
                'nullable',
                'integer',
                Rule::in($perPageOptions)
            ],
            'search' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid parameters',
                'message' => $validator->errors()
            ], 400);
        }

        $searchValue = $request->input('search', '');
        $perPage = $request->input('per_page', 20);

        $query = Publisher::query();

        if (!empty($searchValue)) {
            $query->where('name', 'LIKE', "%{$searchValue}%");
        }

        $publishers = $query->paginate($perPage);

        return PublisherResource::collection($publishers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            'message' => 'Successfully deleted'
        ]);
    }
}
