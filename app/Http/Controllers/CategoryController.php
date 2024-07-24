<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return view("/categories");
    }

    public function show(Category $category)
    {
        return view('categoryShow', compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $category = new Category();
        $category->name = $validated['name'];
        $category->description = $validated['description'];
        $category->save();

        return redirect()->route('categories.show', ['category' => $category->id])
                     ->with('success', 'Category created successfully.');
    }


}
