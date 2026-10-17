<?php

namespace App\Filament\Resources\SellerProfiles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SellerProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('headline'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                Textarea::make('skills')
                    ->helperText('Enter skills as a JSON array, for example: ["Branding", "Figma"]')
                    ->formatStateUsing(fn (?array $state): string => $state ? json_encode($state, JSON_PRETTY_PRINT) : '')
                    ->dehydrateStateUsing(fn (?string $state): array => json_decode($state ?: '[]', true, 512, JSON_THROW_ON_ERROR))
                    ->columnSpanFull(),
                TextInput::make('location'),
            ]);
    }
}
