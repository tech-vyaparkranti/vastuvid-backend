<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model; // Add this import
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewFormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $formType;
    public Model $submission; // Change from formData to a Model instance

    public function __construct(string $formType, Model $submission) // Update the constructor
    {
        $this->formType = $formType;
        $this->submission = $submission;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'New ' . ucfirst(str_replace('_', ' ', $this->formType)) . ' Submission',
        );
    }

    public function content()
    {
        return new Content(
            markdown: 'emails.generic-form',
        );
    }
}