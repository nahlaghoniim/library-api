<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Show a single category
    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['error' => 'Category not found'], 404);

        return response()->json($category);
    }

    // Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    // Update category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['error' => 'Category not found'], 404);

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());
        return response()->json($category);
    }

    // Delete category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['error' => 'Category not found'], 404);

        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
