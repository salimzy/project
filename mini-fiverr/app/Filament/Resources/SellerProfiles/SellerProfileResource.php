<?php

namespace App\Filament\Resources\SellerProfiles;

use App\Filament\Resources\SellerProfiles\Pages\CreateSellerProfile;
use App\Filament\Resources\SellerProfiles\Pages\EditSellerProfile;
use App\Filament\Resources\SellerProfiles\Pages\ListSellerProfiles;
use App\Filament\Resources\SellerProfiles\Schemas\SellerProfileForm;
use App\Filament\Resources\SellerProfiles\Tables\SellerProfilesTable;
use App\Models\SellerProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SellerProfileResource extends Resource
{
    protected static ?string $model = SellerProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'headline';

    public static function form(Schema $schema): Schema
    {
        return SellerProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SellerProfilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSellerProfiles::route('/'),
            'create' => CreateSellerProfile::route('/create'),
            'edit' => EditSellerProfile::route('/{record}/edit'),
        ];
    }
}
