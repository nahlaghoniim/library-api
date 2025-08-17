<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_record_id')->constrained('borrow_records')->cascadeOnDelete();
            $table->decimal('amount', 8, 2);
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fines');
    }
};
