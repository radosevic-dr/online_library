<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Exception;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Publisher $publisher, Request $request)
    {
//        $perPageOptions = [20, 50, 100];
//
//        $perPage = $request->input('per_page', 20);
//
//        if (!in_array($perPage, $perPageOptions)) {
//            $perPage = 20;
//        }
//
//        return PublisherResource::collection(Publisher::paginate($perPage));
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
    public function destroy($id)
    {
        try {
            $publisher = Publisher::findOrFail($id);

            $publisher->delete();
            return response()->json([
                $publisher,
                'message' => 'Publisher deleted successfully.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting publisher.',
            ], $e->getCode());
        }
    }
}
