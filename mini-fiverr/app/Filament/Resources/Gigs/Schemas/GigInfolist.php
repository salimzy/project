<?php

namespace App\Filament\Resources\Gigs\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GigInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('packages')
                    ->columnSpanFull(),
                TextEntry::make('delivery_days')
                    ->numeric(),
                TextEntry::make('status'),
                ImageEntry::make('cover_image')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
