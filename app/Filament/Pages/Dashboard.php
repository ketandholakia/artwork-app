<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\OrderStatsWidget;
use App\Filament\Widgets\ArtworkStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStatsWidget::class,
            ArtworkStatsWidget::class,
        ];
    }
}