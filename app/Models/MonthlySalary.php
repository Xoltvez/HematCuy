<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlySalary extends Model
{
    protected $fillable = ['user_id', 'month_year', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
