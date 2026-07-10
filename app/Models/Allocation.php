<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $fillable = ['user_id', 'category_name', 'amount', 'month_year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
