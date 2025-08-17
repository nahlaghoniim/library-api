@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Available Books</h2>

    <table class="table align-middle">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Available Copies</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr>
                <!-- Title -->
                <td class="fw-semibold">{{ $book->title }}</td>

                <!-- Author -->
                <td>
                    @if($book->authors && $book->authors->isNotEmpty())
                        {{ $book->authors->first()->name }}
                    @else
                        <span class="text-muted">No Author</span>
                    @endif
                </td>

                <!-- Category -->
                <td>
                    @if($book->categories && $book->categories->isNotEmpty())
                        {{ $book->categories->first()->name }}
                    @else
                        <span class="text-muted">No Category</span>
                    @endif
                </td>

                <!-- Copies -->
                <td>
                    <span class="badge bg-{{ $book->available_copies > 0 ? 'success' : 'secondary' }}">
                        {{ $book->available_copies }}
                    </span>
                </td>

                <!-- Action -->
                <td>
                    @if($book->available_copies > 0)
                        <form action="{{ route('member.borrow', $book->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">Borrow</button>
                        </form>
                    @else
                        <span class="text-muted">Unavailable</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
