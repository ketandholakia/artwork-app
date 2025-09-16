<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Widgets\OrderStatsWidget;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    protected function getHeaderWidgets(): array
    {
        return [
            OrderStatsWidget::class,
        ];
    }
}

namespace App\Filament\Resources\OrderResource\Pages\ListOrders\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Orders', Order::count())
                ->description('All orders in the system')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
            
            Stat::make('Completed Orders', Order::where('completed', true)->count())
                ->description('Successfully completed orders')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Pending Orders', Order::where('completed', false)->count())
                ->description('Orders still in progress')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('High Priority', Order::where('priority', '>=', 3)->count())
                ->description('Orders with priority level 3+')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}
