<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;


class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Imagem')
                    ->square(),
                TextColumn::make('firstName')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lastName')
                    ->label('Sobrenome')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Data de cadastro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
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
