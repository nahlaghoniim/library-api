<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->foreignId('author_id')->nullable()->constrained('authors')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('available_copies')->default(0);
            $table->integer('total_copies');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('books');
    }
};

