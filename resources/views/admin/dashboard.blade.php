@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center fw-bold" style="color:#4B3832;">📚 Admin Dashboard</h1>
    <p class="text-center text-muted mb-5">Manage your library’s collections, authors, and loans with ease.</p>

    <div class="row g-4">
        <!-- Books Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100" style="background: #F5E6CC;">
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title fw-bold" style="color:#4B3832;">Books</h5>
                    <p class="card-text fs-5">{{ $booksCount }} total</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-dark rounded-pill px-4">
                            Manage Books
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Authors Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100" style="background: #EAD3C0;">
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title fw-bold" style="color:#3E2C23;">Authors</h5>
                    <p class="card-text fs-5">{{ $authorsCount }} total</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.authors.index') }}" class="btn btn-dark rounded-pill px-4">
                            Manage Authors
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans Card -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 h-100" style="background: #D6C0B3;">
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title fw-bold" style="color:#2F1B12;">Loans</h5>
                    <p class="card-text fs-5">{{ $loansCount }} active</p>
                    <div class="mt-auto">
                        <a href="{{ route('admin.loans.index') }}" class="btn btn-dark rounded-pill px-4">
                            Manage Loans
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
