<?php

namespace App\Filament\Resources\Catergories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use App\Models\Category;

class CatergoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(Category::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('description')
                    ->label('Descrição')
                    ->maxLength(255),
                ColorPicker::make('color')
                    ->label('Cor')
                    ->hex()
                    ->extraInputAttributes(['readonly' => true]),
            ]);
    }
}
