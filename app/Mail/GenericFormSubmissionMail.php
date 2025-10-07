<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericFormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subjectLine;

    public function __construct(array $data, string $subjectLine = 'New Form Submission')
    {
        $this->data = $data;
        $this->subjectLine = $subjectLine;
    }

    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.generic-form') // view file
                    ->with(['data' => $this->data]);
    }
}
