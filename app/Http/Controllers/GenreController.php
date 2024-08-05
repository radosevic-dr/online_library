<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Exception;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $genres = Genre::paginate($perPage);

            return response()->json($genres, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving genres.',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:genres',
            ]);
            $genre = Genre::create([
                'name' => $validated['name'],
            ]);

            return response()->json($genre, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating genre.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $genre = Genre::findOrFail($id);

            return response()->json($genre, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving a single genre.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:genres',
            ]);
            $genre = Genre::findOrFail($id);
            $genre->update([
                'name' => $validated['name'],
            ]);

            return response()->json($genre, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating genre.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();

            return response()->json($genre, 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting genre.',
            ]);
        }
    }
}
