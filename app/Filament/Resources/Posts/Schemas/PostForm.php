<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Category;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),

                TextInput::make('content')
                    ->label('Conteúdo')
                    ->required()
                    ->maxLength(65535),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('thumbnail_url')
                    ->label('URL da imagem')
                    ->url()
                    ->maxLength(2048)
                    ->nullable(),

                TextInput::make('tags')
                    ->label('Tags')
                    ->maxLength(255),

                FileUpload::make('thumbnail')
                    ->label('Ou envie uma imagem do computador')
                    ->image()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                    ->maxSize(2048)
                    ->nullable(),
                
                Toggle::make('published')
                    ->label('Publicar')
                    ->default(false)
                    ->required(),
            ]);
    }
}
