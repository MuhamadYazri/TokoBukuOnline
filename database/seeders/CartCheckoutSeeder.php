<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CartCheckoutSeeder extends Seeder
{
    /**
     * Seed orders that simulate a cart checkout with multiple books.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $books = Book::all();

        if ($customers->isEmpty() || $books->count() < 3) {
            return;
        }

        $checkoutSamples = $customers->take(5);

        foreach ($checkoutSamples as $customer) {
            $cartSize = rand(3, min(6, $books->count()));
            $cartBooks = $books->random($cartSize);

            $order = Order::create([
                'user_id' => $customer->id,
                'order_number' => 'ORD-CART-' . strtoupper(Str::random(6)),
                'book_id' => $cartBooks->first()->id,
                'total_quantity' => 0,
                'total_price' => 0,
                'status' => 'completed',
            ]);

            $totalQuantity = 0;
            $totalPrice = 0;

            foreach ($cartBooks as $book) {
                $quantity = rand(1, 3);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $book->price,
                ]);

                $totalQuantity += $quantity;
                $totalPrice += $quantity * $book->price;
            }

            $order->update([
                'total_quantity' => $totalQuantity,
                'total_price' => $totalPrice,
            ]);
        }
    }
}
