<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
    }

    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) return response()->json(['error' => 'Author not found'], 404);
        return response()->json($author);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'bio' => 'nullable|string',
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) return response()->json(['error' => 'Author not found'], 404);

        $request->validate([
            'name' => 'sometimes|string|max:150',
            'bio' => 'nullable|string',
        ]);

        $author->update($request->all());
        return response()->json($author);
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) return response()->json(['error' => 'Author not found'], 404);

        $author->delete();
        return response()->json(['message' => 'Author deleted']);
    }
}
