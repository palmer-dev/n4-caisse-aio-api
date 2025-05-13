<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Sale;
use App\Models\Shop;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $now    = now();
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push( $now->copy()->subMonths( $i )->format( 'Y-m' ) );
        }

        // Récupération des données
        $salesData   = $this->getMonthlyCounts( Sale::class, $months );
        $shopsData   = $this->getMonthlyCounts( Shop::class, $months );
        $usersData   = $this->getMonthlyCounts( Employee::class, $months );
        $clientsData = $this->getMonthlyCounts( Client::class, $months );

        return [
            $this->makeStatCard( 'Commandes totales', Sale::count(), $salesData ),
            $this->makeStatCard( 'Boutiques', Shop::count(), $shopsData ),
            $this->makeStatCard( 'Utilisateurs', Employee::count(), $usersData ),
            $this->makeStatCard( 'Clients', Client::count(), $clientsData ),
        ];
    }

    /**
     * Récupère le nombre d’enregistrements groupé par mois pour un modèle donné.
     */
    protected function getMonthlyCounts(string $modelClass, $months, string $dateColumn = 'created_at'): array
    {
        $rawData = $modelClass::selectRaw( "DATE_FORMAT({$dateColumn}, '%Y-%m') as month, COUNT(*) as total" )
            ->where( $dateColumn, '>=', now()->copy()->subMonths( 6 )->startOfMonth() )
            ->groupBy( 'month' )
            ->pluck( 'total', 'month' );

        $chart = $months->map( fn($month) => $rawData[$month] ?? 0 )->toArray();

        $current  = $chart[5];
        $previous = $chart[4] ?? 0;

        $trend   = $previous > 0 ? round( (($current - $previous) / $previous) * 100 ) : ($current > 0 ? 100 : 0);
        $trendUp = $trend >= 0;

        return [
            'chart' => $chart,
            'trend' => abs( $trend ),
            'is_up' => $trendUp,
        ];
    }

    /**
     * Construit une carte de statistique avec graphique et tendance.
     */
    protected function makeStatCard(string $label, int $value, array $data): Stat
    {
        return Stat::make( $label, $value )
            ->description( ($data['is_up'] ? '+' : '-') . $data['trend'] . '% par rapport au mois précédent' )
            ->descriptionIcon( $data['is_up'] ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down' )
            ->color( $data['is_up'] ? 'success' : 'danger' )
            ->chart( $data['chart'] );
    }
}
