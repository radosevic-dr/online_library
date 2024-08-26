<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadIcon(CategoryRequest $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::findOrFail($categoryId);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $path = $file->store('icons', 'public');

            $category->update(['icon' => $path]);

            return response()->json(new CategoryRequest($category), 200);
        }

        Log::error('No file uploaded');

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
