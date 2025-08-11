<?php

namespace App\Filament\Resources\TraitFeedbackTemplateResource\Pages;

use App\Filament\Resources\TraitFeedbackTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTraitFeedbackTemplates extends ListRecords
{
    protected static string $resource = TraitFeedbackTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
