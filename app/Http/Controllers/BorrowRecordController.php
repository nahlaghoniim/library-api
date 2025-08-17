<?php

namespace App\Http\Controllers;

use App\Models\BorrowRecord;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowRecordController extends Controller
{
    // List all borrow records
    public function index()
    {
        $records = BorrowRecord::with(['user', 'book'])->get();
        return response()->json($records);
    }

    // Show a single borrow record
    public function show($id)
    {
        $record = BorrowRecord::with(['user', 'book'])->find($id);
        if (!$record) return response()->json(['error' => 'Borrow record not found'], 404);

        return response()->json($record);
    }

    // Create a borrow record (borrow a book)
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $book = Book::find($request->book_id);

        // Check if book is available
        if ($book->available_copies <= 0) {
            return response()->json(['error' => 'Book not available'], 400);
        }

        // Decrease available copies
        DB::transaction(function () use ($book, $request) {
            $book->decrement('available_copies');

            BorrowRecord::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'borrow_date' => $request->borrow_date,
                'due_date' => $request->due_date,
                'status' => 'borrowed',
            ]);
        });

        return response()->json(['message' => 'Book borrowed successfully'], 201);
    }

    // Update a borrow record (for returning a book)
    public function update(Request $request, $id)
    {
        $record = BorrowRecord::find($id);
        if (!$record) return response()->json(['error' => 'Borrow record not found'], 404);

        $request->validate([
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'status' => 'required|in:borrowed,returned,late',
        ]);

        // Increase available copies if book is returned
        if ($record->status !== 'returned' && $request->status === 'returned') {
            $record->book->increment('available_copies');
        }

        $record->update($request->only(['return_date', 'status']));

        return response()->json($record);
    }

    // Delete a borrow record
    public function destroy($id)
    {
        $record = BorrowRecord::find($id);
        if (!$record) return response()->json(['error' => 'Borrow record not found'], 404);

        // Restore available copies if record is deleted and not returned
        if ($record->status !== 'returned') {
            $record->book->increment('available_copies');
        }

        $record->delete();
        return response()->json(['message' => 'Borrow record deleted']);
    }
}
