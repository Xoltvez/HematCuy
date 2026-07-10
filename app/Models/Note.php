<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'amount',
        'is_paid',
        'due_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
