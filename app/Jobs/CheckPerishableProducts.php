<?php

namespace App\Jobs;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\StockResource;
use App\Models\StockExpiration;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckPerishableProducts implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $expired = StockExpiration::whereDate( 'expiration_date', '<', now()->addDays( intval( config( "app.shop.perishable_product_alert_days" ) ) ) ?? 0 );

        $expired->each( function (StockExpiration $stock) {
            // Récupérer les destinataires (les managers)
            $recipients = $stock->stockMovements->stock->shop->managers;
            $quantity   = $stock->stockMovements->quantity;

            // Création de la notification
            Notification::make()
                ->title( 'Alerte de péremption de stock !' )
                ->body(
                    "⚠️ {$quantity} unités de `{$stock->stockMovements->sku->computed_name}` "
                    . "a une date de péremption dépassée ou sera dépassée dans les {$stock->getDaysUntilExpiration()} jours. "
                    . "Il est urgent de vérifier et de traiter cette partie du stock."
                )
                ->icon( 'heroicon-o-exclamation-circle' ) // Icône d'avertissement
                ->iconColor( 'danger' ) // Couleur de l'icône
                ->color( 'danger' ) // Couleur de la notification
                ->actions( [
                    // Action pour voir le stock (date de péremption)
                    Action::make( 'Voir les stocks périssables' )
                        ->url( StockResource::getUrl( 'edit', ['record' => $stock->stockMovements->stock] ) ),
                    // Action pour voir l'article associé à la date de péremption
                    Action::make( 'Voir l\'article' )
                        ->url( ProductResource::getUrl( 'edit', ['record' => $stock->stockMovements->sku->product] ) ),
                ] )
                ->sendToDatabase( $recipients ); // Envoi de la notification aux managers
        } );

    }
}
