<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_id',
        'amount',
        'account',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'date',
        ];
    }

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
