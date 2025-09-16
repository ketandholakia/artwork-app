<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Artwork;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count())
                ->description('All orders in the system')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->url(route('filament.admin.resources.orders.index')),
            
            Stat::make('Completed Orders', Order::where('completed', true)->count())
                ->description('Successfully completed orders')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Pending Orders', Order::where('completed', false)->count())
                ->description('Orders still in progress')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->url(route('filament.admin.resources.orders.index', ['tableFilters[completed][value]' => false])),
            
            Stat::make('High Priority', Order::where('priority', '>=', 3)->count())
                ->description('Orders with priority level 3+')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}