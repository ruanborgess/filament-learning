<?php

namespace App\Filament\Resources\Catergories\Pages;

use App\Filament\Resources\Catergories\CatergoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatergory extends CreateRecord
{
    protected static string $resource = CatergoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
