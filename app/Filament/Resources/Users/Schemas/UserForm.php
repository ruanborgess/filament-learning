<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use App\Models\User;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
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
                    ->maxLength(255),
                TextInput::make('image')
                    ->label('Imagem')
                    ->url()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required(fn (?User $record): bool => $record === null)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (string $state): ?string => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state)),
            ]);
    }
}
