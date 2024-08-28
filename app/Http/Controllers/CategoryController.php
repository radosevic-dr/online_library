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
        $search = $request->query('search', '');

        $validator = Validator::make([
            'per_page' => $perPage,
        ], [
            'per_page' => [
                'required',
                'integer',
                Rule::in($perPageOptions),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categoriesQuery = Category::query();

        if ($search) {
            $categoriesQuery->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $categories = $categoriesQuery->paginate($perPage);

        return CategoryResource::collection($categories);
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

    public function update(Category $category, Request $request)
    {
        $category->update(
            $request->validate([
                'name' => 'sometimes|max:500',
                'description' => 'sometimes|max:500',
                'icon' => 'nullable|max:5120',
            ])
        );

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
