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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->enum('category', [
                'pengembangan-diri',
                'fiksi',
                'filosofi',
                'psikologi',
                'bisnis',
                'teknologi',
                'sejarah',
                'biografi',
                'sains',
                'kesehatan',
                'agama',
                'seni',
                'pendidikan',
                'kuliner',
                'anak'
            ])->default('pengembangan-diri');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->year('year');
            $table->string('publisher')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->default('Indonesia');
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
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
