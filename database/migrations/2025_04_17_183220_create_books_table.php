<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('books');
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id');
            $table->string('strand')->nullable();
            $table->string('reference')->nullable();
            $table->string('category')->nullable();
            $table->string('track')->nullable();
            $table->string('type')->nullable();
            $table->longText('title')->nullable();
            $table->string('author')->nullable();
            $table->year('year')->nullable();
            $table->enum('status', ['borrowed', 'available', 'missing'])->default('available');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
