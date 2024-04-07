<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_store', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->references('id')->on('books')->cascadeOnDelete();
            $table->foreignId('store_id')->references('id')->on('stores')->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_store');
    }
};
