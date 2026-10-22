<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do usuário')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('firstName')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('lastName')
                                    ->label('Sobrenome')
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('E-mail')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Imagem do usuário')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('image_url')
                                    ->label('Usar URL da imagem')
                                    ->url()
                                    ->maxLength(2048)
                                    ->live(debounce: 500)
                                    ->formatStateUsing(fn (?User $record): ?string => filter_var($record?->image, FILTER_VALIDATE_URL)
                                        ? $record->image
                                        : null)
                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                        if (filled($state)) {
                                            $set('image', null);
                                        }
                                    })
                                    ->visible(fn (Get $get): bool => blank($get('image'))),

                                FileUpload::make('image')
                                    ->label('Ou enviar imagem')
                                    ->image()
                                    ->disk('public')
                                    ->directory('users')
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                                    ->maxSize(2048)
                                    ->live()
                                    ->formatStateUsing(fn (?User $record) => filter_var($record?->image, FILTER_VALIDATE_URL)
                                        ? null
                                        : $record?->image)
                                    ->afterStateUpdated(function ($state, Set $set): void {
                                        if (filled($state)) {
                                            $set('image_url', null);
                                        }
                                    })
                                    // Keep the upload mounted until Livewire finishes transferring the file.
                                    ->visible(fn (Get $get): bool => blank($get('image_url'))),
                            ]),

                        Section::make('Prévia da imagem')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('image_url_preview')
                                    ->hiddenLabel()
                                    ->content(fn (Get $get): HtmlString => new HtmlString(
                                        '<img src="' . e($get('image_url')) . '" alt="Prévia da imagem" style="max-width: 100%; max-height: 240px; object-fit: contain;">'
                                    )),
                            ])
                            ->headerActions([
                                Action::make('removeImageUrl')
                                    ->label('Remover imagem')
                                    ->icon(Heroicon::XMark)
                                    ->iconButton()
                                    ->color('danger')
                                    ->tooltip('Remover imagem')
                                    ->action(fn (Set $set) => $set('image_url', null)),
                            ])
                            ->visible(fn (Get $get): bool => filled($get('image_url'))),
                    ])
                    ->columns(1),

                Section::make('Acesso')
                    ->schema([
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->required(fn (?User $record): bool => $record === null)
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? bcrypt($state) : null)
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                    ])
                    ->columns(1),
            ]);
    }
}
