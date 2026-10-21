<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255),

                        RichEditor::make('content')
                            ->label('Conteúdo')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                Section::make('Meta')
                    ->schema([
                        Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('tags')
                            ->label('Tags')
                            ->maxLength(255),

                        TextInput::make('thumbnail_url')
                            ->label('Use URL da imagem')
                            ->url()
                            ->maxLength(2048)
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (?string $state, Set $set): void {
                                if (filled($state)) {
                                    $set('thumbnail', null);
                                }
                            })
                            ->visible(fn (Get $get): bool => blank($get('thumbnail')) && blank($get('thumbnail_url'))),

                        FileUpload::make('thumbnail')
                            ->label('Ou use imagem local')
                            ->image()
                            ->disk('public')
                            ->directory('thumbnails')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->maxSize(2048)
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set): void {
                                if (filled($state)) {
                                    $set('thumbnail_url', null);
                                }
                            })
                            ->visible(fn (Get $get): bool => blank($get('thumbnail')) && blank($get('thumbnail_url'))),

                        Section::make('Prévia da imagem')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('thumbnail_preview')
                                    ->hiddenLabel()
                                    ->content(function (Get $get): HtmlString {
                                        $url = $get('thumbnail_url');
                                        $thumbnail = $get('thumbnail');

                                        if (blank($url) && filled($thumbnail)) {
                                            $url = is_object($thumbnail) && method_exists($thumbnail, 'temporaryUrl')
                                                ? $thumbnail->temporaryUrl()
                                                : Storage::disk('public')->url($thumbnail);
                                        }

                                        return new HtmlString(
                                            '<img src="' . e($url) . '" alt="Prévia da imagem" style="max-width: 100%; max-height: 240px; object-fit: contain;">'
                                        );
                                    }),
                            ])
                            ->headerActions([
                                Action::make('removeThumbnail')
                                ->label('Remover imagem')
                                ->icon(Heroicon::XMark)
                                ->iconButton()
                                ->color('danger')
                                ->tooltip('Remover imagem')
                                ->action(function (Set $set): void {
                                    $set('thumbnail', null);
                                    $set('thumbnail_url', null);
                                }),
                            ])
                            ->visible(fn (Get $get): bool => filled($get('thumbnail')) || filled($get('thumbnail_url'))),

                        Toggle::make('published')
                            ->label('Publicado'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
