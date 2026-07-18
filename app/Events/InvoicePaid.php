<?php

namespace App\Events;

use App\Models\Invoice;
use App\Models\MobileMoneyTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoicePaid
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public ?MobileMoneyTransaction $transaction = null
    ) {}
}
