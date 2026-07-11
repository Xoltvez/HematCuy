<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'otp_code', 'otp_expires_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'otp_code',
        'otp_expires_at',
        'daily_budget',
        'daily_alert_sent_at',
        'profile_photo_path',
        'alert_daily_budget',
        'alert_weekly_report',
        'alert_email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function monthlySalaries()
    {
        return $this->hasMany(MonthlySalary::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function debts()
    {
        return $this->hasMany(Debt::class);
    }
}
