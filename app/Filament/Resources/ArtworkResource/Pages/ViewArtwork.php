<?php

namespace App\Filament\Resources\ArtworkResource\Pages;

use App\Filament\Resources\ArtworkResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArtwork extends ViewRecord
{
    protected static string $resource = ArtworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
