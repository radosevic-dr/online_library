<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
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
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            'message' => 'Successfully deleted'
        ]);
    }
}
