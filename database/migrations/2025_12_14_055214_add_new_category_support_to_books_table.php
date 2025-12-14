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
        Schema::table('books', function (Blueprint $table) {
            $table->string('category')->change();
            $table->string('language')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
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
            ])->change();
        });
    }
};
