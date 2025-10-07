<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenericFormSubmissionMail;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = "contact_us";

    const ID = "id";
    const NAME = "name";
    const EMAIL = "email";
    const PHONE_NUMBER = "phone";
    const MESSAGE = "message";
    const SUBJECT = 'subject';
    const IP_ADDRESS = "ip_address";
    const CREATED_AT = 'created_at';

    /**
     * Send email when a new contact form is submitted.
     */
    protected static function booted()
    {
        static::created(function ($model) {
            Mail::to('chandan@vyaparkranti.com')->send(
                new GenericFormSubmissionMail($model->toArray(), 'New Contact Us Message')
            );
        });
    }
}
