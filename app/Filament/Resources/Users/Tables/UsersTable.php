<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use App\Enum\Role;


class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Função')
                    ->formatStateUsing(fn (?Role $state): string => $state?->value ?? '—')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Imagem')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->square(),
                TextColumn::make('firstName')
                    ->label('Nome')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('lastName')
                    ->label('Sobrenome')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Data de cadastro')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Função')
                    ->options([
                        Role::Admin->value => 'Administrador',
                        Role::Editor->value => 'Editor',
                        Role::Subscriber->value => 'Usuário',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
