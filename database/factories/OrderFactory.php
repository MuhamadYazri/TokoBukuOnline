<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;
    public function definition(): array
    {

        return [
            'user_id' => User::where('role', 'customer')->inRandomOrder()->first()->id ?? User::factory(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'book_id' => Book::inRandomOrder()->first()->id ?? Book::factory(),
            'total_quantity' => $quantity = fake()->numberBetween(1, 5),
            'total_price' => $quantity * fake()->numberBetween(50000, 150000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'created_at' => fake()->dateTimeBetween('-12 months', 'now')

        ];
    }

    public function pending()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function completed()
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'completed'
        ]);
    }

    public function forMonth($month, $year = null)
    {
        $year = $year ?? date('Y');

        return $this->state(fn(array $attributes) => [
            'created_at' => fake()->dateTimeBetween(
                "{$year}-{$month}-01",
                "{$year}-{$month}-" . date('t', strtotime("{$year}-{$month}-01"))
            ),
        ]);
    }
}
