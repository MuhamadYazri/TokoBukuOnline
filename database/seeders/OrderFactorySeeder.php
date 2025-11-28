<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $customer = User::where('role', 'customer')->get();

        $monthGenerate = 12;
        $totalOrder = 0;

        for ($i = $monthGenerate - 1; $i >= 1; $i--) {

            $date = now()->subMonth($i);
            $month = $date->month;
            $year = $date->year;

            $orderCount = rand(10, 30);

            for ($j = 0; $j < $orderCount; $j++) {
                $customer = User::where('role', 'customer')
                    ->inRandomOrder()
                    ->first();

                $status = fake()->randomElement([
                    'completed',
                    'completed',
                    'completed',
                    'processing',
                    'pending',
                    'cancelled',
                ]);

                $order = Order::factory()->forMonth($month, $year)->create([
                    'user_id' => $customer->id,
                    'status' => $status
                ]);
            }

            $detailsCount = rand(1, 3);
            $books = Book::inRandomOrder()->limit($detailsCount)->get();

            foreach ($books as $book) {
                $quantity = rand(1, 3);

                OrderDetail::factory()->create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $book->price,
                ]);
            }

            $order->update([
                'total_quantity' => $order->orderDetails->sum('quantity'),
                'total_price' => $order->orderDetails->sum(fn($detail) => $detail->quantity * $detail->price),
            ]);

            $totalOrder++;
        }
    }
}
