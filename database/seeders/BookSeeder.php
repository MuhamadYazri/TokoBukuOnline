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
                'price' => 89000,
                'stock' => 25,
                'year' => 2005,
                'description' => 'Novel inspiratif tentang perjuangan anak-anak Belitung dalam menempuh pendidikan di tengah keterbatasan.',
                'cover' => null,
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'price' => 95000,
                'stock' => 18,
                'year' => 1980,
                'description' => 'Novel sejarah tentang kehidupan Minke, seorang pribumi di masa kolonial Belanda.',
                'cover' => null,
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'Ahmad Fuadi',
                'price' => 85000,
                'stock' => 30,
                'year' => 2009,
                'description' => 'Kisah inspiratif santri di Pondok Madani yang bermimpi meraih cita-cita setinggi menara.',
                'cover' => null,
            ],
            [
                'title' => 'Perahu Kertas',
                'author' => 'Dee Lestari',
                'price' => 78000,
                'stock' => 22,
                'year' => 2009,
                'description' => 'Novel romantis tentang Kugy dan Keenan yang mengejar mimpi dan cinta.',
                'cover' => null,
            ],
            [
                'title' => 'Ronggeng Dukuh Paruk',
                'author' => 'Ahmad Tohari',
                'price' => 82000,
                'stock' => 15,
                'year' => 1982,
                'description' => 'Trilogi tentang Srintil, seorang ronggeng dari Dukuh Paruk yang menghadapi takdir tragis.',
                'cover' => null,
            ],

            // Non-Fiksi & Self-Help
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'price' => 120000,
                'stock' => 40,
                'year' => 2018,
                'description' => 'Panduan praktis membangun kebiasaan baik dan menghilangkan kebiasaan buruk dengan perubahan kecil.',
                'cover' => null,
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'price' => 110000,
                'stock' => 35,
                'year' => 1997,
                'description' => 'Pelajaran tentang literasi keuangan dan investasi dari dua ayah dengan pandangan berbeda.',
                'cover' => null,
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'price' => 115000,
                'stock' => 28,
                'year' => 2020,
                'description' => 'Wawasan tentang hubungan emosional manusia dengan uang dan cara mengelola keuangan.',
                'cover' => null,
            ],
            [
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'price' => 135000,
                'stock' => 20,
                'year' => 2011,
                'description' => 'Sejarah singkat umat manusia dari era batu hingga era digital.',
                'cover' => null,
            ],
            [
                'title' => 'Man Search for Meaning',
                'author' => 'Viktor E. Frankl',
                'price' => 98000,
                'stock' => 24,
                'year' => 1946,
                'description' => 'Refleksi mendalam tentang pencarian makna hidup dari seorang psikiater di kamp konsentrasi Nazi.',
                'cover' => null,
            ],

            // Programming & Tech
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'price' => 150000,
                'stock' => 15,
                'year' => 2008,
                'description' => 'Panduan menulis kode yang bersih, mudah dibaca, dan maintainable.',
                'cover' => null,
            ],
            [
                'title' => 'Laravel: Up & Running',
                'author' => 'Matt Stauffer',
                'price' => 180000,
                'stock' => 12,
                'year' => 2019,
                'description' => 'Panduan komprehensif belajar framework Laravel dari basic hingga advanced.',
                'cover' => null,
            ],
            [
                'title' => 'Head First Design Patterns',
                'author' => 'Eric Freeman',
                'price' => 165000,
                'stock' => 10,
                'year' => 2004,
                'description' => 'Belajar design patterns dengan pendekatan visual yang mudah dipahami.',
                'cover' => null,
            ],
            [
                'title' => 'You Don\'t Know JS',
                'author' => 'Kyle Simpson',
                'price' => 145000,
                'stock' => 18,
                'year' => 2014,
                'description' => 'Deep dive ke JavaScript untuk memahami cara kerja bahasa ini secara mendalam.',
                'cover' => null,
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'Andrew Hunt',
                'price' => 175000,
                'stock' => 14,
                'year' => 1999,
                'description' => 'Filosofi dan praktik terbaik untuk menjadi programmer yang lebih baik.',
                'cover' => null,
            ],

            // Komik & Manga
            [
                'title' => 'One Piece Vol. 1',
                'author' => 'Eiichiro Oda',
                'price' => 35000,
                'stock' => 50,
                'year' => 1997,
                'description' => 'Petualangan Monkey D. Luffy mencari harta karun legendaris One Piece.',
                'cover' => null,
            ],
            [
                'title' => 'Naruto Vol. 1',
                'author' => 'Masashi Kishimoto',
                'price' => 35000,
                'stock' => 45,
                'year' => 1999,
                'description' => 'Kisah ninja muda Naruto Uzumaki yang bermimpi menjadi Hokage.',
                'cover' => null,
            ],
            [
                'title' => 'Attack on Titan Vol. 1',
                'author' => 'Hajime Isayama',
                'price' => 40000,
                'stock' => 38,
                'year' => 2009,
                'description' => 'Pertarungan umat manusia melawan titan raksasa yang mengancam peradaban.',
                'cover' => null,
            ],
            [
                'title' => 'Death Note Vol. 1',
                'author' => 'Tsugumi Ohba',
                'price' => 38000,
                'stock' => 42,
                'year' => 2003,
                'description' => 'Light Yagami menemukan buku kematian dan memulai misi membersihkan dunia dari penjahat.',
                'cover' => null,
            ],
            [
                'title' => 'Your Name',
                'author' => 'Makoto Shinkai',
                'price' => 65000,
                'stock' => 25,
                'year' => 2016,
                'description' => 'Novel grafis romantis tentang dua remaja yang bertukar tubuh secara misterius.',
                'cover' => null,
            ],

            // Buku Anak
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'author' => 'J.K. Rowling',
                'price' => 125000,
                'stock' => 35,
                'year' => 1997,
                'description' => 'Petualangan Harry Potter yang menemukan dunia sihir di Hogwarts.',
                'cover' => null,
            ],
            [
                'title' => 'The Little Prince',
                'author' => 'Antoine de Saint-Exupéry',
                'price' => 75000,
                'stock' => 30,
                'year' => 1943,
                'description' => 'Kisah filosofis tentang pangeran kecil yang menjelajahi planet-planet.',
                'cover' => null,
            ],
            [
                'title' => 'Charlie and the Chocolate Factory',
                'author' => 'Roald Dahl',
                'price' => 85000,
                'stock' => 28,
                'year' => 1964,
                'description' => 'Petualangan Charlie Bucket di pabrik cokelat ajaib milik Willy Wonka.',
                'cover' => null,
            ],
            [
                'title' => 'Matilda',
                'author' => 'Roald Dahl',
                'price' => 80000,
                'stock' => 26,
                'year' => 1988,
                'description' => 'Cerita gadis jenius dengan kekuatan telekinesis melawan kepala sekolah yang kejam.',
                'cover' => null,
            ],
            [
                'title' => 'Wonder',
                'author' => 'R.J. Palacio',
                'price' => 95000,
                'stock' => 32,
                'year' => 2012,
                'description' => 'Kisah inspiratif Auggie Pullman, anak dengan kelainan wajah yang bersekolah di sekolah umum.',
                'cover' => null,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
