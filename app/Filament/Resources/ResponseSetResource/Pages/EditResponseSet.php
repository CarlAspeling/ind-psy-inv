<?php

namespace App\Filament\Resources\ResponseSetResource\Pages;

use App\Filament\Resources\ResponseSetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponseSet extends EditRecord
{
    protected static string $resource = ResponseSetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
