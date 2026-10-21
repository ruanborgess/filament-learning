<?php

namespace App\Filament\Resources\Catergories\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: false)
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
                Action::make('edit')
                    ->label('Editar')
                    ->url(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
