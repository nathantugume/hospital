<?php

namespace App\Events;

use App\Models\LabResult;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AbnormalLabResult
{
    use Dispatchable, SerializesModels;

    public function __construct(public LabResult $labResult) {}
}
