<?php

namespace App\Filament\Resources\ArtworkResource\Pages;

use App\Filament\Resources\ArtworkResource;
use App\Models\Artwork;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Widgets\ArtworkStatsWidget;


class ListArtworks extends ListRecords
{
    protected static string $resource = ArtworkResource::class;

     protected function getHeaderWidgets(): array
    {
        return [
            ArtworkStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
