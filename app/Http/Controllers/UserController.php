<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // List all users (admin only)
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Show a single user
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        return response()->json($user);
    }

    // Create a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', Password::defaults()],
            'role' => 'in:admin,user',
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => ['sometimes', Password::defaults()],
            'role' => 'sometimes|in:admin,user',
        ]);

        $user->update($request->all());
        return response()->json($user);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'User not found'], 404);

        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
