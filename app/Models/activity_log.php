<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createLog($userId, $activityType, $description = null)
    {
        return self::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'description' => $description
        ]);
    }
}
