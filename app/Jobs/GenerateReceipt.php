<?php

namespace App\Jobs;

use App\Models\Sale;
use App\Services\ReceiptService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateReceipt implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Sale $sale)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(ReceiptService $receiptService): void
    {
        $receiptService->getReceipt( $this->sale );
    }
}
