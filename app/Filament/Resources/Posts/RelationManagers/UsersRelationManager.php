<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Users\Schemas\UserForm;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('firstName')
            ->columns([
                TextColumn::make('firstName')
                    ->label('Nome')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading('No users')
            ->emptyStateIcon(Heroicon::OutlinedXMark)
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(fn (array $data): array => $this->mergeImageUrl($data)),
                AttachAction::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateDataUsing(fn (array $data): array => $this->mergeImageUrl($data)),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private function mergeImageUrl(array $data): array
    {
        if (filled($data['image_url'] ?? null)) {
            $data['image'] = $data['image_url'];
        }

        unset($data['image_url']);

        return $data;
    }
}
 