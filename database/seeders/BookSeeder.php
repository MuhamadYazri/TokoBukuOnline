<?php

namespace Database\Seeders;

use App\Models\Book;
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
            // Fiksi Indonesia
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'category' => 'fiksi', // ← Tambahkan
                'price' => 89000,
                'stock' => 25,
                'year' => 2005,
                'description' => 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam menempuh pendidikan di tengah keterbatasan.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'category' => 'fiksi', // ← Tambahkan
                'price' => 95000,
                'stock' => 18,
                'year' => 1980,
                'description' => 'Novel sejarah tentang kehidupan Minke, seorang pribumi di masa kolonial Belanda.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'category' => 'fiksi', // ← Tambahkan
                'price' => 85000,
                'stock' => 30,
                'year' => 2009,
                'description' => 'Kisah inspiratif santri di Pondok Madani yang bermimpi meraih cita-cita setinggi menara.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Perahu Kertas',
                'author' => 'Dee Lestari',
                'category' => 'fiksi', // ← Tambahkan
                'price' => 78000,
                'stock' => 22,
                'year' => 2009,
                'description' => 'Novel romantis tentang Kugy dan Keenan yang mengejar mimpi dan cinta.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'category' => 'fiksi', // ← Tambahkan
                'price' => 82000,
                'stock' => 15,
                'year' => 1982,
                'description' => 'Trilogi tentang Srintil, seorang ronggeng dari Dukuh Paruk yang menghadapi takdir tragis.',
                'cover' => 'img/img-book.webp',
            ],

            // Non-Fiksi & Self-Help
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'category' => 'pengembangan-diri', // ← Tambahkan
                'price' => 120000,
                'stock' => 40,
                'year' => 2018,
                'description' => 'Panduan praktis membangun kebiasaan baik dan menghilangkan kebiasaan buruk dengan perubahan kecil.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'category' => 'pengembangan-diri', // ← Tambahkan
                'price' => 110000,
                'stock' => 35,
                'year' => 1997,
                'description' => 'Pelajaran tentang literasi keuangan dan investasi dari dua ayah dengan pandangan berbeda.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'category' => 'psikologi', // ← Tambahkan
                'price' => 115000,
                'stock' => 28,
                'year' => 2020,
                'description' => 'Wawasan tentang hubungan emosional manusia dengan uang dan cara mengelola keuangan.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'category' => 'filosofi', // ← Tambahkan
                'price' => 135000,
                'stock' => 20,
                'year' => 2011,
                'description' => 'Sejarah singkat umat manusia dari era batu hingga era digital.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'category' => 'filosofi', // ← Tambahkan
                'price' => 95000,
                'stock' => 30,
                'year' => 2019,
                'description' => 'Buku tentang filsafat Stoicism untuk kehidupan modern.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Man Search for Meaning',
                'author' => 'Viktor E. Frankl',
                'category' => 'psikologi', // ← Tambahkan
                'price' => 98000,
                'stock' => 24,
                'year' => 1946,
                'description' => 'Refleksi mendalam tentang pencarian makna hidup dari seorang psikiater di kamp konsentrasi Nazi.',
                'cover' => 'img/img-book.webp',
            ],

            // Programming & Tech (gunakan 'pengembangan-diri' atau tambah enum 'teknologi')
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category' => 'pengembangan-diri', // ← Tambahkan
                'price' => 150000,
                'stock' => 15,
                'year' => 2008,
                'description' => 'Panduan menulis kode yang bersih, mudah dibaca, dan maintainable.',
                'cover' => 'img/img-book.webp',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
