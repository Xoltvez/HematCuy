<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'target_date',
        'saved_amount',
        'purchased_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
