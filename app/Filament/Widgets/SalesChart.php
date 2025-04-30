<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Évolution du chiffre d’affaires';

    public ?string $startDate = null;
    public ?string $endDate = null;

    public ?string $filter = 'year';
    protected int|string|array $columnSpan = 'full';

    protected function getFilters(): ?array
    {
        return [
            'today'     => 'Today',
            'week'      => 'Last 7 days',
            'month'     => 'Last 30 days',
            'last_year' => 'Last year',
            'year'      => 'This year',
        ];
    }

    protected function getData(): array
    {
        $start = Carbon::parse( now() )->startOfMonth();
        $end   = Carbon::parse( now() )->endOfMonth();

        switch ($this->filter) {
            case 'today':
                $start = Carbon::parse( now() )->startOfDay();
                $end   = Carbon::parse( now() )->endOfDay();
                break;
            case 'week':
                $start = Carbon::parse( now() )->startOfDay()->addDays( -7 );
                $end   = Carbon::parse( now() )->endOfDay();
                break;
            case 'year':
                $start = Carbon::parse( now() )->startOfYear();
                $end   = Carbon::parse( now() )->endOfYear();
                break;
            case 'last_year':
                $start = Carbon::parse( now() )->startOfYear()->addYears( -1 );
                $end   = Carbon::parse( now() )->endOfYear()->addYears( -1 );
                break;
            case 'month':
                $start = Carbon::parse( now() )->startOfMonth();
                $end   = Carbon::parse( now() )->endOfMonth();
                break;
        }

        $period  = collect();
        $current = $start->copy();

        while ($current <= $end) {
            $period->push( $current->copy() );
            switch ($this->filter) {
                case 'today':
                    $current->addHour();
                    break;
                case 'month':
                case 'week':
                    $current->addDay();
                    break;
                case 'year':
                case 'last_year':
                    $current->addMonth();
                    break;
            }
        }

        $labels = [];
        $data   = [];

        foreach ($period as $month) {
            switch ($this->filter) {
                case 'today':
                    $labels[] = $month->format( 'g:ia' );
                    $current->addHour();
                    break;
                case 'month':
                case 'week':
                    $labels[] = $month->format( 'd M Y' );
                    $current->addDay();
                    break;
                case 'year':
                case 'last_year':
                    $labels[] = $month->format( 'M Y' );
                    break;
            }

            $total = Sale::whereYear( 'created_at', $month->year )
                ->whereMonth( 'created_at', $month->month )
                ->sum( 'grand_total' );

            $data[] = round( $total / 100, 2 );
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Chiffre d’affaires (€)',
                    'data'            => $data,
                    'backgroundColor' => 'rgba(59,130,246,0.5)',
                    'borderColor'     => 'rgba(59,130,246,1)',
                    'tension'         => 0.4,
                ],
            ],
            'labels'   => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
