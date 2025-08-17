<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Loan;

class AdminController extends Controller
{
    public function dashboard() {
        return view('admin.dashboard', [
            'booksCount' => Book::count(),
            'authorsCount' => Author::count(),
            'loansCount' => Loan::whereNull('returned_at')->count(),
        ]);
    }
}
