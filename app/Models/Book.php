<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category',
        'price',
        'stock',
        'year',
        'cover',
        'description'
    ];

    const CATEGORIES = [
        'pengembangan-diri' => 'Pengembangan Diri',
        'fiksi' => 'Fiksi',
        'filosofi' => 'Filosofi',
        'psikologi' => 'Psikologi',
    ];

    public static function getCategories()
    {
        return self::CATEGORIES;
    }

    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? 'Pengembangan Diri';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function isAvailable()
    {
        return $this->stock > 0;
    }

    public function decreaseStock($quantity)
    {
        $this->stock -= $quantity;
        $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }

    public function reviews()
    {
        return $this->hasMany(BookReview::class);
    }

    // HELPER METHOD untuk rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function totalReviews()
    {
        return $this->reviews()->count();
    }

    public function ratingBreakdown()
    {
        return [
            '5_star' => $this->reviews()->where('rating', 5)->count(),
            '4_star' => $this->reviews()->where('rating', 4)->count(),
            '3_star' => $this->reviews()->where('rating', 3)->count(),
            '2_star' => $this->reviews()->where('rating', 2)->count(),
            '1_star' => $this->reviews()->where('rating', 1)->count(),
        ];
    }
}
