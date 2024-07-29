<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['first_name', 'last_name', 'biography']);
        $author = Author::create($data);

        if ($request->hasFile('picture')) {
            $author->addMedia($request->file('picture'))->toMediaCollection('pictures');
        }

        return response()->json($author->load('media'), 201);
    }

    public function show($id)
    {
        $author = Author::with('media')->find($id);

        if (! $author) {
            return response()->json(['error' => 'Author not found'], 404);
        }

        return response()->json($author);
    }

    public function getPicture($id)
    {
        $author = Author::find($id);

        if (! $author) {
            return response()->json(['error' => 'Author not found'], 404);
        }

        $mediaItems = $author->getMedia('pictures');
        if ($mediaItems->isEmpty()) {
            return response()->json(['error' => 'Picture not found'], 404);
        }

        $picture = $mediaItems->first();

        return response()->download($picture->getPath(), $picture->file_name);
    }
}
