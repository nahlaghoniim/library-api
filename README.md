📚 Library Management System
🔹 Overview

A full-featured Library Management System built with Laravel, designed for both Admins and Members.
It supports book management, borrowing/returning, categories, authors, and reviews with role-based access control.

✨ Features

👨‍💻 Admin Panel: Manage books, categories, and authors.

📖 Member Access: Browse books, borrow and return copies.

🔐 Role-based authentication (Admin & Member).

📊 Borrow records and availability tracking.

🌐 RESTful API endpoints for external integrations.

📝 Reviews system for members to rate and review books.

🔹 Tech Stack

Backend: Laravel 10, PHP 8+

Database: MySQL / PostgreSQL

Frontend: Blade (Bootstrap 5)

Authentication: Laravel Breeze

API Security: Laravel Sanctum

Testing: PHPUnit / Pest

🔹 Database ERD


![Database ERD](docs/erd.png)
🔹 Installation
# Clone repository
git clone https://github.com/your-username/library-management-system.git
cd library-management-system

# Install dependencies
composer install
npm install && npm run dev

# Copy .env file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure DB connection in .env

# Run migrations + seeders
php artisan migrate --seed

# Start local server
php artisan serve

🔹 Default Users (Seeded)

Admin

Email: admin@example.com

Password: password

Member

Email: member@example.com

Password: password

🔹 API Endpoints
Method	Endpoint	Description
GET	/api/books	List all books
GET	/api/books/{id}	Show book details
POST	/api/borrow/{id}	Borrow a book
POST	/api/return/{id}	Return a book
GET	/api/categories	List categories
GET	/api/authors	List authors
🔹 Screenshots


🔹 Contribution

Fork the repo

Create a new branch (feature/xyz)

Commit changes

Push and create a Pull Request
