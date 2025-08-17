<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class FineController extends Controller
{
    // List all fines
    public function index()
    {
        $fines = Fine::with(['borrowRecord.user', 'borrowRecord.book'])->get();
        return response()->json($fines);
    }

    // Show a single fine
    public function show($id)
    {
        $fine = Fine::with(['borrowRecord.user', 'borrowRecord.book'])->find($id);
        if (!$fine) return response()->json(['error' => 'Fine not found'], 404);

        return response()->json($fine);
    }

    // Create a fine for a borrow record
    public function store(Request $request)
    {
        $request->validate([
            'borrow_record_id' => 'required|exists:borrow_records,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Optional: Check if fine already exists for the borrow record
        $existing = Fine::where('borrow_record_id', $request->borrow_record_id)->first();
        if ($existing) {
            return response()->json(['error' => 'Fine already exists for this borrow record'], 400);
        }

        $fine = Fine::create([
            'borrow_record_id' => $request->borrow_record_id,
            'amount' => $request->amount,
            'paid' => false,
        ]);

        return response()->json($fine, 201);
    }

    // Update a fine (for marking as paid)
    public function update(Request $request, $id)
    {
        $fine = Fine::find($id);
        if (!$fine) return response()->json(['error' => 'Fine not found'], 404);

        $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'paid' => 'sometimes|boolean',
        ]);

        $fine->update($request->only(['amount', 'paid']));

        return response()->json($fine);
    }

    // Delete a fine
    public function destroy($id)
    {
        $fine = Fine::find($id);
        if (!$fine) return response()->json(['error' => 'Fine not found'], 404);

        $fine->delete();
        return response()->json(['message' => 'Fine deleted']);
    }
}
