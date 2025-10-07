<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericFormSubmissionMail;

class Seo extends Model
{
    use HasFactory;

    protected $table = "seos";

    protected $fillable = [
        'website_url','phone' ,'ip_address'
    ];


    protected static function booted()
{
    static::created(function ($model) {
        Mail::to('chandan@vyaparkranti.com')->send(
            new GenericFormSubmissionMail($model->toArray(), 'New SEO Submission')
        );
    });
}
}
