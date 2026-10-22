<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Width;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                ImageColumn::make('thumbnail')
                    ->label('Imagem')
                    ->getStateUsing(function ($record): ?string {
                        if (filled($record->thumbnail_url)) {
                            return $record->thumbnail_url;
                        }

                        if (blank($record->thumbnail)) {
                            return null;
                        }

                        $path = implode('/', array_map(
                            rawurlencode(...),
                            explode('/', ltrim($record->thumbnail, '/')),
                        ));

                        return request()->getSchemeAndHttpHost() . '/storage/' . $path;
                    })
                    ->disk('public')
                    ->visibility('public')
                    ->imageSize(100)
                    ->square()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('title')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Data de criação')
                    ->dateTime('d/m/Y H:i')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                ToggleColumn::make('published')
                    ->label('Publicado'),
                
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalWidth(Width::SevenExtraLarge),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
