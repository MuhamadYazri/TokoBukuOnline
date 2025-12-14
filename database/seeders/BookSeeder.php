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

            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'category' => 'teknologi',
                'price' => 150000,
                'stock' => 15,
                'year' => 2008,
                'description' => 'Panduan menulis kode yang bersih, mudah dibaca, dan maintainable.',
                'cover' => 'img/img-book.webp',
            ],

            // Bisnis & Ekonomi
            [
                'title' => 'Good to Great',
                'author' => 'Jim Collins',
                'category' => 'bisnis',
                'price' => 125000,
                'stock' => 20,
                'year' => 2001,
                'description' => 'Studi mendalam tentang bagaimana perusahaan baik menjadi perusahaan hebat.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'category' => 'bisnis',
                'price' => 115000,
                'stock' => 25,
                'year' => 2011,
                'description' => 'Panduan membangun startup yang sukses dengan metode lean.',
                'cover' => 'img/img-book.webp',
            ],

            // Sejarah
            [
                'title' => 'Bung Karno: Penyambung Lidah Rakyat',
                'author' => 'Cindy Adams',
                'category' => 'sejarah',
                'price' => 98000,
                'stock' => 18,
                'year' => 1965,
                'description' => 'Otobiografi Presiden pertama Indonesia, Ir. Soekarno.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Indonesia: Dari Kolonialisme Sampai Nasionalisme',
                'author' => 'Sartono Kartodirdjo',
                'category' => 'sejarah',
                'price' => 105000,
                'stock' => 15,
                'year' => 1999,
                'description' => 'Analisis perjalanan sejarah Indonesia dari masa kolonial hingga kemerdekaan.',
                'cover' => 'img/img-book.webp',
            ],

            // Biografi
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'category' => 'biografi',
                'price' => 145000,
                'stock' => 22,
                'year' => 2011,
                'description' => 'Biografi lengkap pendiri Apple Inc. yang mengubah dunia teknologi.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Becoming',
                'author' => 'Michelle Obama',
                'category' => 'biografi',
                'price' => 135000,
                'stock' => 28,
                'year' => 2018,
                'description' => 'Memoar inspiratif mantan First Lady Amerika Serikat.',
                'cover' => 'img/img-book.webp',
            ],

            // Sains & Matematika
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'category' => 'sains',
                'price' => 125000,
                'stock' => 20,
                'year' => 1988,
                'description' => 'Penjelasan sederhana tentang alam semesta dari ahli fisika terkemuka.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Cosmos',
                'author' => 'Carl Sagan',
                'category' => 'sains',
                'price' => 130000,
                'stock' => 18,
                'year' => 1980,
                'description' => 'Eksplorasi luar biasa tentang alam semesta dan tempat manusia di dalamnya.',
                'cover' => 'img/img-book.webp',
            ],

            // Kesehatan & Lifestyle
            [
                'title' => 'Why We Sleep',
                'author' => 'Matthew Walker',
                'category' => 'kesehatan',
                'price' => 118000,
                'stock' => 25,
                'year' => 2017,
                'description' => 'Pentingnya tidur untuk kesehatan fisik dan mental.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'The Blue Zones',
                'author' => 'Dan Buettner',
                'category' => 'kesehatan',
                'price' => 112000,
                'stock' => 20,
                'year' => 2008,
                'description' => 'Rahasia panjang umur dari daerah-daerah dengan harapan hidup tertinggi.',
                'cover' => 'img/img-book.webp',
            ],

            // Agama & Spiritualitas
            [
                'title' => 'The Power of Now',
                'author' => 'Eckhart Tolle',
                'category' => 'agama',
                'price' => 108000,
                'stock' => 30,
                'year' => 1997,
                'description' => 'Panduan spiritual untuk menemukan kebahagiaan di momen sekarang.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Negeri Maiyah',
                'author' => 'Cak Nun & Emha Ainun Nadjib',
                'category' => 'agama',
                'price' => 95000,
                'stock' => 22,
                'year' => 2010,
                'description' => 'Kumpulan pemikiran spiritual dan sosial dari Cak Nun.',
                'cover' => 'img/img-book.webp',
            ],

            // Seni & Budaya
            [
                'title' => 'Tempo Doeloe',
                'author' => 'Pramoedya Ananta Toer',
                'category' => 'seni',
                'price' => 88000,
                'stock' => 16,
                'year' => 1982,
                'description' => 'Kumpulan cerita tentang kehidupan dan budaya Indonesia tempo dulu.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Ways of Seeing',
                'author' => 'John Berger',
                'category' => 'seni',
                'price' => 92000,
                'stock' => 18,
                'year' => 1972,
                'description' => 'Analisis mendalam tentang cara kita melihat dan memahami seni.',
                'cover' => 'img/img-book.webp',
            ],

            // Pendidikan
            [
                'title' => 'Sekolah Itu Candu',
                'author' => 'Roem Topatimasang',
                'category' => 'pendidikan',
                'price' => 75000,
                'stock' => 24,
                'year' => 2013,
                'description' => 'Kritik terhadap sistem pendidikan konvensional di Indonesia.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Pendidikan Kaum Tertindas',
                'author' => 'Paulo Freire',
                'category' => 'pendidikan',
                'price' => 85000,
                'stock' => 20,
                'year' => 1970,
                'description' => 'Teori pendidikan kritis untuk pembebasan sosial.',
                'cover' => 'img/img-book.webp',
            ],

            // Kuliner
            [
                'title' => 'Salt, Fat, Acid, Heat',
                'author' => 'Samin Nosrat',
                'category' => 'kuliner',
                'price' => 135000,
                'stock' => 28,
                'year' => 2017,
                'description' => 'Empat elemen dasar memasak yang baik dan lezat.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Buku Masakan Nusantara',
                'author' => 'William Wongso',
                'category' => 'kuliner',
                'price' => 125000,
                'stock' => 22,
                'year' => 2015,
                'description' => 'Kumpulan resep masakan tradisional Indonesia dari berbagai daerah.',
                'cover' => 'img/img-book.webp',
            ],

            // Anak & Remaja
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'category' => 'anak',
                'price' => 98000,
                'stock' => 35,
                'year' => 1997,
                'description' => 'Petualangan ajaib Harry Potter di dunia sihir Hogwarts.',
                'cover' => 'img/img-book.webp',
            ],
            [
                'title' => 'Lupus',
                'author' => 'Hilman Hariwijaya',
                'category' => 'anak',
                'price' => 65000,
                'stock' => 30,
                'year' => 1987,
                'description' => 'Komik strip legendaris tentang kehidupan remaja Indonesia.',
                'cover' => 'img/img-book.webp',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
