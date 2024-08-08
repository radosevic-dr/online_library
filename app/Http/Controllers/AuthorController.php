<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'per_page' => 'integer|in:20,50,100',
            'search' => 'string|nullable',
        ]);

        $perPage = $validated['per_page'] ?? 20;
        $search = $validated['search'] ?? null;

        $query = Author::query();

        if ($search) {
            $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%");
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Author $author)
    {
        $author->load('media');

        return response()->json($author);
    }

    public function getPicture(Author $author)
    {
        $media = $author->getFirstMedia('pictures');

        return response()->json($media);
    }

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

    public function update(Request $request, Author $author)
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
        $author->update($data);

        if ($request->hasFile('picture')) {
            $author->clearMediaCollection('pictures');
            $author->addMedia($request->file('picture'))->toMediaCollection('pictures');
        }

        return response()->json($author->load('media'));
    }

    public function destroy(Author $author)
    {
        $author->clearMediaCollection('pictures');
        $author->delete();

        return response()->json(null, 204);
    }
}
