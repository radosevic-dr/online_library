<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    // No middleware for now

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            // 'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Commented out for now
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['first_name', 'last_name', 'biography']);

        $author = Author::create($data);

        // Picture handling commented out for now
        // if ($request->hasFile('picture')) {
        //     $author
        //         ->addMedia($request->file('picture'))
        //         ->toMediaCollection('pictures');
        // }

        return response()->json($author, 201);
    }
}
