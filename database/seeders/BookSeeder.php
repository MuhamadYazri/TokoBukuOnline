<?php

namespace Database\Seeders;

use App\Models\book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'price' => 89000,
                'year' => 2020,
                'stock' => 50,
                'cover' => 'laskar-pelangi.jpg',
                'description' => 'Novel tentang perjuangan 10 anak Melayu Belitong yang berjuang keras untuk mendapatkan pendidikan.'
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'price' => 95000,
                'year' => 2021,
                'stock' => 30,
                'cover' => 'bumi-manusia.jpg',
                'description' => 'Novel sejarah tentang kehidupan di Indonesia pada masa kolonial Belanda.'
            ]
        ];
        foreach ($books as $book) {
            book::create($book);
        }
    }
}
