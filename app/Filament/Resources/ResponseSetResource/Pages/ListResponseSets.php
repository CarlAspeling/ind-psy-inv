<?php

namespace App\Filament\Resources\ResponseSetResource\Pages;

use App\Filament\Resources\ResponseSetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponseSets extends ListRecords
{
    protected static string $resource = ResponseSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
