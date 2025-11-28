<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = OrderDetail::class;
    public function definition(): array
    {
        $book = Book::inRandomOrder()->first() ?? Book::factory()->create();
        $quantity = fake()->numberBetween(1, 5);
        return [

            'order_id' => Order::factory(),
            'book_id' => $book->id,
            'quantity' => $quantity,
            'price' => $book->price,

        ];
    }

    public function forOrder($orderId)
    {
        return $this->state(fn(array $attributes) => [
            'order_id' => $orderId,
        ]);
    }

    public function forBook($bookId)
    {
        return $this->state(fn(array $attributes) => [
            'book_id' => $bookId
        ]);
    }
}
