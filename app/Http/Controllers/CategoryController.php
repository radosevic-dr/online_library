<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'per_page' => 20,
        ];

        $perPageOptions = [20, 50, 100];

        $validator = Validator::make($data, [
            'per_page' => [
                'required',
                'integer',
                Rule::in($perPageOptions),
            ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors], 400);
        }

        $perPage = $data['per_page'];
        
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

    public function update(Category $category, Request $request)
    {
        $category->update(
            $request->validate([
                "name" => "sometimes|max:500",
                "description" => "sometimes|max:500",
                "icon" => "nullable|max:5120",
            ])
        );
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(status: 204);
    }
}
