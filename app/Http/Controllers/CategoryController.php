<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPageOptions = [20, 50, 100];
        $perPage = $request->query('per_page', 20); // Default value is 20

        $validator = Validator::make(['per_page' => $perPage], [
            'per_page' => [
                'required',
                'integer',
                Rule::in($perPageOptions),
            ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json(['errors' => $errors], 422);
        }

        return CategoryResource::collection(Category::paginate($perPage));
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        // Update category details
        $category->update($request->validated());

        // Return the updated category resource
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
