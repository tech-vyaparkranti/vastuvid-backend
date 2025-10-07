<?php

// app/Models/DomainPurchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainPurchase extends Model
{
    protected $fillable = [
        'user_id', 'domain', 'tld', 'years', 'status', 'reseller_data'
    ];

    protected $casts = [
        'reseller_data' => 'array',
    ];
}
