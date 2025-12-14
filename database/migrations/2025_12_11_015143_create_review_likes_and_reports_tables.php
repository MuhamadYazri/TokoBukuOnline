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
        Schema::create('review_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_review_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure one user can only like a review once
            $table->unique(['user_id', 'book_review_id']);
        });

        Schema::create('review_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_review_id')->constrained()->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->timestamps();

            // Ensure one user can only report a review once
            $table->unique(['user_id', 'book_review_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_reports');
        Schema::dropIfExists('review_likes');
    }
};
