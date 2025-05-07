<?php

namespace App\Filament\Resources\ResponseOptionsResource\Pages;

use App\Filament\Resources\ResponseOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponseOptions extends ListRecords
{
    protected static string $resource = ResponseOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
