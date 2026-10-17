<?php

namespace App\Filament\Resources\Gigs;

use App\Filament\Resources\Gigs\Pages\CreateGig;
use App\Filament\Resources\Gigs\Pages\EditGig;
use App\Filament\Resources\Gigs\Pages\ListGigs;
use App\Filament\Resources\Gigs\Pages\ViewGig;
use App\Filament\Resources\Gigs\Schemas\GigForm;
use App\Filament\Resources\Gigs\Schemas\GigInfolist;
use App\Filament\Resources\Gigs\Tables\GigsTable;
use App\Models\Gig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GigResource extends Resource
{
    protected static ?string $model = Gig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return GigForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GigInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GigsTable::configure($table);
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
            'index' => ListGigs::route('/'),
            'create' => CreateGig::route('/create'),
            'view' => ViewGig::route('/{record}'),
            'edit' => EditGig::route('/{record}/edit'),
        ];
    }
}
