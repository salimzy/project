<?php

namespace App\Filament\Resources\Gigs\Pages;

use App\Filament\Resources\Gigs\GigResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGig extends ViewRecord
{
    protected static string $resource = GigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
