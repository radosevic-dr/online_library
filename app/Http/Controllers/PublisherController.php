<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Exception;
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
        try {
            $perPageOptions = [20, 50, 100];

            $searchValue = $request->input('search', '');
            $perPage = $request->input('per_page', 20); // Default to 20 if not defined

            if (!in_array($perPage, $perPageOptions)) {
                $perPage = 20;
            }

            $validator = Validator::make($request->all(), [
                'search' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Invalid parameters',
                    'message' => $validator->errors()
                ], 400);
            }

            $query = Publisher::query();
            if (!empty($searchValue)) {
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $publishers = $query->paginate($perPage);

            return response()->json([
                'data' => PublisherResource::collection($publishers),
                'meta' => [
                    'total' => $publishers->total(),
                    'per_page' => $publishers->perPage(),
                    'current_page' => $publishers->currentPage(),
                    'last_page' => $publishers->lastPage(),
                ]
            ]);
        }catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
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
