<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua customer users
        $customers = User::where('role', 'customer')->get();

        // Ambil semua buku
        $books = Book::all();

        // Data review template
        $reviewTemplates = [
            // Rating 5
            [
                'rating' => 5,
                'reviews' => [
                    'Buku yang sangat bagus! Sangat menginspirasi dan mudah dipahami. Recommended!',
                    'Luar biasa! Buku ini benar-benar mengubah perspektif saya. Must read!',
                    'Sempurna! Penulisannya menarik dan isi sangat bermanfaat.',
                    'Buku terbaik yang pernah saya baca! 5 bintang tanpa ragu.',
                    'Sangat merekomendasikan buku ini! Worth every penny!',
                    'Masterpiece! Tidak menyesal membeli buku ini.',
                    'Buku yang wajib dibaca! Sangat inspiratif dan motivatif.',
                ]
            ],
            // Rating 4
            [
                'rating' => 4,
                'reviews' => [
                    'Buku yang bagus dan menarik. Beberapa bagian bisa lebih detail.',
                    'Konten sangat baik, tapi ada beberapa bagian yang agak membosankan.',
                    'Overall bagus! Recommended untuk yang tertarik dengan topik ini.',
                    'Buku yang berkualitas. Ada beberapa insight menarik.',
                    'Bacaan yang menyenangkan. Cukup informatif.',
                    'Bagus! Tapi ending-nya kurang memuaskan.',
                    'Konten solid, tapi penulisan bisa lebih engaging.',
                ]
            ],
            // Rating 3
            [
                'rating' => 3,
                'reviews' => [
                    'Lumayan bagus. Tidak terlalu istimewa tapi juga tidak mengecewakan.',
                    'Biasa saja. Ada bagian yang menarik tapi ada juga yang membosankan.',
                    'Cukup informatif, tapi kurang mendalam.',
                    'Oke lah untuk dibaca. Tidak terlalu memorable.',
                    'Standard. Sesuai ekspektasi, tidak lebih tidak kurang.',
                    'Kontennya cukup, tapi penyampaiannya bisa lebih baik.',
                ]
            ],
            // Rating 2
            [
                'rating' => 2,
                'reviews' => [
                    'Agak mengecewakan. Tidak sesuai dengan deskripsi.',
                    'Kurang menarik. Banyak bagian yang repetitif.',
                    'Tidak sesuai ekspektasi. Terlalu banyak filler.',
                    'Membosankan. Sulit untuk menyelesaikannya.',
                    'Kurang recommend. Ada buku lain yang lebih bagus.',
                ]
            ],
            // Rating 1
            [
                'rating' => 1,
                'reviews' => [
                    'Sangat mengecewakan. Tidak worth it sama sekali.',
                    'Buku terburuk yang pernah saya beli. Waste of money.',
                    'Tidak recommended. Konten sangat shallow.',
                    'Maaf, tapi buku ini benar-benar tidak bagus.',
                ]
            ],
        ];

        // Generate reviews untuk setiap buku
        foreach ($books as $book) {
            // Random jumlah review antara 3-8 per buku
            $reviewCount = rand(3, 8);

            // Shuffle customers agar random
            $shuffledCustomers = $customers->shuffle();

            for ($i = 0; $i < $reviewCount && $i < $shuffledCustomers->count(); $i++) {
                // Probabilitas rating (lebih banyak rating tinggi)
                $ratingProbability = rand(1, 100);

                if ($ratingProbability <= 50) {
                    // 50% chance rating 5
                    $ratingGroup = 0;
                } elseif ($ratingProbability <= 80) {
                    // 30% chance rating 4
                    $ratingGroup = 1;
                } elseif ($ratingProbability <= 95) {
                    // 15% chance rating 3
                    $ratingGroup = 2;
                } elseif ($ratingProbability <= 98) {
                    // 3% chance rating 2
                    $ratingGroup = 3;
                } else {
                    // 2% chance rating 1
                    $ratingGroup = 4;
                }

                $selectedTemplate = $reviewTemplates[$ratingGroup];
                $randomReview = $selectedTemplate['reviews'][array_rand($selectedTemplate['reviews'])];

                // Cek apakah user sudah review buku ini
                $existingReview = BookReview::where('user_id', $shuffledCustomers[$i]->id)
                    ->where('book_id', $book->id)
                    ->first();

                if (!$existingReview) {
                    BookReview::create([
                        'user_id' => $shuffledCustomers[$i]->id,
                        'book_id' => $book->id,
                        'rating' => $selectedTemplate['rating'],
                        'review' => $randomReview,
                        'created_at' => now()->subDays(rand(1, 60)), // Random date dalam 60 hari terakhir
                    ]);
                }
            }
        }

        $this->command->info('✅ Book reviews seeded successfully!');
        $this->command->info('📝 Total reviews: ' . BookReview::count());
    }
}
