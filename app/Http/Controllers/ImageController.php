<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryRequest;

class ImageController extends Controller
{
    public function uploadIcon(CategoryRequest $request)
    {

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $path = $file->store('icons', 'public');


            return response()->json(['path' => $path], 200);
        }

        Log::error('No file uploaded');

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
