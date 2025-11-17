<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'review'
    ];

    // RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // HELPER METHODS
    public static function averageRating($bookId)
    {
        return self::where('book_id', $bookId)->avg('rating');
    }

    public static function totalReviews($bookId)
    {
        return self::where('book_id', $bookId)->count();
    }
}
