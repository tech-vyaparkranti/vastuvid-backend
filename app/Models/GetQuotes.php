<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\GenericFormSubmissionMail;
use Illuminate\Support\Facades\Mail;

class GetQuotes extends Model
{
    use HasFactory;

    protected $table = "get_quotes";

    protected $fillable = [
        'name',
        'location',
        'phone',
        'message'
    ];

    
}
