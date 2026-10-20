<?php

namespace App\Filament\Resources\Catergories\Pages;

use App\Filament\Resources\Catergories\CatergoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatergory extends EditRecord
{
    protected static string $resource = CatergoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
