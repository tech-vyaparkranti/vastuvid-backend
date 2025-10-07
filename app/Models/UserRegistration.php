<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'phone',
        'phone_cc',
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
