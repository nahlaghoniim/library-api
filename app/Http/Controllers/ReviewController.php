<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // List all reviews
    public function index()
    {
        $reviews = Review::with(['user', 'book'])->get();
        return response()->json($reviews);
    }

    // Show a single review
    public function show($id)
    {
        $review = Review::with(['user', 'book'])->find($id);
        if (!$review) return response()->json(['error' => 'Review not found'], 404);

        return response()->json($review);
    }

    // Create a new review
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        // Optional: prevent multiple reviews per user per book
        $existing = Review::where('user_id', $request->user_id)
                          ->where('book_id', $request->book_id)
                          ->first();
        if ($existing) {
            return response()->json(['error' => 'You have already reviewed this book'], 400);
        }

        $review = Review::create($request->only(['user_id', 'book_id', 'rating', 'comment']));
        return response()->json($review, 201);
    }

    // Update a review
    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) return response()->json(['error' => 'Review not found'], 404);

        $request->validate([
            'rating' => 'sometimes|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->only(['rating', 'comment']));
        return response()->json($review);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) return response()->json(['error' => 'Review not found'], 404);

        $review->delete();
        return response()->json(['message' => 'Review deleted']);
    }
}
