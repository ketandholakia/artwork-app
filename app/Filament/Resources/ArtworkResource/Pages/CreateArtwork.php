<?php

namespace App\Filament\Resources\ArtworkResource\Pages;

use App\Filament\Resources\ArtworkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArtwork extends CreateRecord
{
    protected static string $resource = ArtworkResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
