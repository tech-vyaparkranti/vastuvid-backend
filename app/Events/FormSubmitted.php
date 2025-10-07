<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model; // Add this import
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $formType;
    public Model $model; // Change formData to a Model instance

    public function __construct(string $formType, Model $model) // Update the constructor
    {
        $this->formType = $formType;
        $this->model = $model;
    }
}