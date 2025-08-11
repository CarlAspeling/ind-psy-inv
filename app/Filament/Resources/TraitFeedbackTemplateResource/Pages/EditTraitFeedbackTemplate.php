<?php

namespace App\Filament\Resources\TraitFeedbackTemplateResource\Pages;

use App\Filament\Resources\TraitFeedbackTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTraitFeedbackTemplate extends EditRecord
{
    protected static string $resource = TraitFeedbackTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
