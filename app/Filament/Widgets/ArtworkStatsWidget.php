<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Artwork;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArtworkStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Artworks', Artwork::count())
                ->description('All Artworks in the system')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->url(route('filament.admin.resources.artworks.index')),
            
            Stat::make('Completed Artworks', Artwork::where('prepressstage', true)->count())
                ->description('Successfully proceeded Artworks')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Pending Artworks', Artwork::where('prepressstage', false)->count())
                ->description('Artworks still pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                 ->url(route('filament.admin.resources.artworks.index', [
                    'tableFilters' => [
                        'prepressstage' => [
                            'value' => '0'
                        ]
                    ]
                ])),
        
           Stat::make('High Priority', Artwork::where('priority', '=', 1)->count())
                ->description('Artwork with priority level 3+')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger')
                ->url(route('filament.admin.resources.artworks.index', [
                    'tableFilters' => [
                        'priority' => [
                            'value' => 'high'
                        ]
                    ]
                ])),      
        ];
    }
}