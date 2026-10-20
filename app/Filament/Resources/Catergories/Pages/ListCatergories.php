<?php

namespace App\Filament\Resources\Catergories\Pages;

use App\Filament\Resources\Catergories\CatergoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatergories extends ListRecords
{
    protected static string $resource = CatergoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
