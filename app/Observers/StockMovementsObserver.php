<?php

namespace App\Observers;

use App\Enums\MovementTypeEnum;
use App\Jobs\ProcessStockMovement;
use App\Models\StockMovements;

class StockMovementsObserver
{
    /**
     * Handle the StockMovements "created" event.
     */
    public function created(StockMovements $stockMovements): void
    {
        if ($stockMovements->movement_type === MovementTypeEnum::INPUT)
            $stockMovements->stock->quantity += $stockMovements->quantity;

        if ($stockMovements->movement_type === MovementTypeEnum::OUTPUT)
            $stockMovements->stock->quantity -= $stockMovements->quantity;


        $stockMovements->stock->save();

        // Only call the job if the movement is an output
        if ($stockMovements->movement_type === MovementTypeEnum::OUTPUT)
            ProcessStockMovement::dispatch( $stockMovements->stock );
    }
}
