<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Author;
use App\Models\Book;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // ----------------------
        // Users
        // ----------------------
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member',
                'password' => bcrypt('password'),
                'role' => 'member'
            ]
        );

        // ----------------------
        // Categories
        // ----------------------
        $categories = [
            ['name' => 'Fiction', 'slug' => 'fiction'],
            ['name' => 'Non-fiction', 'slug' => 'non-fiction'],
            ['name' => 'Science', 'slug' => 'science'],
            ['name' => 'History', 'slug' => 'history'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }

        // ----------------------
        // Authors
        // ----------------------
        $authors = [
            ['name' => 'J.K. Rowling'],
            ['name' => 'George Orwell'],
            ['name' => 'Isaac Asimov'],
        ];

        foreach ($authors as $author) {
            Author::updateOrCreate(['name' => $author['name']]);
        }

        // ----------------------
        // Books
        // ----------------------
        $books = [
            [
                'title' => '1984',
                'category_slug' => 'fiction',
                'authors' => ['George Orwell'],
                'total_copies' => 5,
            ],
            [
                'title' => 'Foundation',
                'category_slug' => 'science',
                'authors' => ['Isaac Asimov'],
                'total_copies' => 5,
            ],
        ];

        foreach ($books as $bookData) {
            $category = Category::where('slug', $bookData['category_slug'])->first();

            $book = Book::updateOrCreate(
                ['title' => $bookData['title']],
                [
                    'category_id' => $category->id ?? null,
                    'total_copies' => $bookData['total_copies'] ?? 1,
                ]
            );

            // Attach authors
            $authorIds = Author::whereIn('name', $bookData['authors'])->pluck('id')->toArray();
            $book->authors()->sync($authorIds);
        }
    }
}
