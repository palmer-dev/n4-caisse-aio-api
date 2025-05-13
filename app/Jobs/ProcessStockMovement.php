<?php

namespace App\Jobs;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\StockResource;
use App\Models\Stock;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessStockMovement implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Stock $stock)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->stock->quantity < intval( config( "app.shop.low_quantity_alert" ) )) {
            $recipients = $this->stock->shop->managers;
            Notification::make()
                ->title( 'Stock faible !' )
                ->body( "Le stock de l'article `{$this->stock->sku->computed_name}` est inférieur au seuil critique ({$this->stock->quantity} unités restantes)." )
                ->icon( 'heroicon-o-exclamation-circle' )
                ->iconColor( 'danger' )
                ->color( 'danger' )
                ->actions( [
                    Action::make( 'Voir le stock' )->url( StockResource::getUrl( 'edit', ['record' => $this->stock] ) ),
                    Action::make( 'Voir le l\'article' )->url( ProductResource::getUrl( 'edit', ['record' => $this->stock->product] ) ),
                ] )
                ->sendToDatabase( $recipients );
        }
    }
}
