<?php

namespace App\Filament\Resources\Gigs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Seller')
                    ->relationship('seller', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(false),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('packages')
                    ->helperText('Enter package data as JSON. Example: [{"name":"Basic","price":25}]')
                    ->formatStateUsing(fn (?array $state): string => $state ? json_encode($state, JSON_PRETTY_PRINT) : '')
                    ->dehydrateStateUsing(fn (?string $state): array => json_decode($state ?: '[]', true, 512, JSON_THROW_ON_ERROR))
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('delivery_days')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->default('pending'),
                FileUpload::make('cover_image')
                    ->image(),
            ]);
    }
}
