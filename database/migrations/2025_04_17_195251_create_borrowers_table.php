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
        Schema::dropIfExists('borrowers');
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id('borrower_id')->primary();
            $table->foreignId('book_id')->index();
            $table->string('borrower_name');
            $table->string('borrower_section');
            $table->timestamp('borrowed_at');
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
