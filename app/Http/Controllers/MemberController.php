<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dashboard() {
        /** @var User $user */
        $user = auth()->user();

        return view('member.dashboard', [
'books' => Book::with(['author','category'])->get(),
            'loans' => $user->loans()->with('book')->get(),
        ]);
    }
}
