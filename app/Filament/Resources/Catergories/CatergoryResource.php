<?php

namespace App\Filament\Resources\Catergories;

use App\Filament\Resources\Catergories\RelationManagers\PostsRelationManager;
use App\Filament\Resources\Catergories\Pages\CreateCatergory;
use App\Filament\Resources\Catergories\Pages\EditCatergory;
use App\Filament\Resources\Catergories\Pages\ListCatergories;
use App\Filament\Resources\Catergories\Pages\ViewCatergory;
use App\Filament\Resources\Catergories\Schemas\CatergoryForm;
use App\Filament\Resources\Catergories\Tables\CatergoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatergoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CatergoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatergoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatergories::route('/'),
            'create' => CreateCatergory::route('/create'),
            'view' => ViewCatergory::route('/{record}'),
            'edit' => EditCatergory::route('/{record}/edit'),
        ];
    }
}
