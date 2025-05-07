<?php

namespace App\Filament\Resources\ResponseOptionsResource\Pages;

use App\Filament\Resources\ResponseOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponseOptions extends EditRecord
{
    protected static string $resource = ResponseOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
