<?php

namespace App\Listeners;

use App\Events\FormSubmitted;
use App\Mail\NewFormSubmissionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendFormSubmissionEmail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(FormSubmitted $event)
    {
        Mail::to('mjha8290@gmail.com')->send(new NewFormSubmissionMail($event->formType, $event->model));
    }
}