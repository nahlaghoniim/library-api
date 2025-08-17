<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // List all books with author and category
    public function index()
    {
        $books = Book::with(['author', 'category'])->get();
        return response()->json($books);
    }

    // Show single book with author and category
    public function show($id)
    {
        $book = Book::with(['author', 'category'])->find($id);
        if (!$book) return response()->json(['error' => 'Book not found'], 404);

        return response()->json($book);
    }

    // Create a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'available_copies' => 'nullable|integer|min:0',
            'total_copies' => 'required|integer|min:1',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    // Update book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['error' => 'Book not found'], 404);

        $request->validate([
            'title' => 'sometimes|string|max:150',
            'author_id' => 'sometimes|exists:authors,id',
            'category_id' => 'sometimes|exists:categories,id',
            'available_copies' => 'nullable|integer|min:0',
            'total_copies' => 'sometimes|integer|min:1',
        ]);

        $book->update($request->all());
        return response()->json($book);
    }

    // Delete book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) return response()->json(['error' => 'Book not found'], 404);

        $book->delete();
        return response()->json(['message' => 'Book deleted']);
    }
}
