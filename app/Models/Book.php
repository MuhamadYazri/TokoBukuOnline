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
        'pages',
        'publisher',
        'language',
        'year',
        'cover',
        'description'
    ];

    const CATEGORIES = [
        'pengembangan-diri' => 'Pengembangan Diri',
        'fiksi' => 'Fiksi',
        'filosofi' => 'Filosofi',
        'psikologi' => 'Psikologi',
        'bisnis' => 'Bisnis & Ekonomi',
        'teknologi' => 'Teknologi & Komputer',
        'sejarah' => 'Sejarah',
        'biografi' => 'Biografi',
        'sains' => 'Sains & Matematika',
        'kesehatan' => 'Kesehatan & Lifestyle',
        'agama' => 'Agama & Spiritualitas',
        'seni' => 'Seni & Budaya',
        'pendidikan' => 'Pendidikan',
        'kuliner' => 'Kuliner',
        'anak' => 'Anak & Remaja',
    ];

    public static function getCategories()
    {
        $defaultCategories = self::CATEGORIES;

        $customCategories = Book::select('category')
            ->whereNotIn('category', array_keys($defaultCategories))
            ->groupBy('category')
            ->pluck('category')
            ->mapWithKeys(function ($category) {
                return [$category => ucwords(str_replace('-', ' ', $category))];
            })
            ->toArray();

        $categories = array_merge($defaultCategories, $customCategories);
        return $categories;
    }

    public function getCategoryNameAttribute()
    {
        return self::CATEGORIES[$this->category] ?? ucwords(str_replace('-', ' ', $this->category));
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
