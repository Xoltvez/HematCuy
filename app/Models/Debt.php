<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'person_name',
        'amount',
        'amount_paid',
        'due_date',
        'status',
        'account',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function installments()
    {
        return $this->hasMany(DebtInstallment::class);
    }
}
