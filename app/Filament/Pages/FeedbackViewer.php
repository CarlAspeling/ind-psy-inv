<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class FeedbackViewer extends Page
{
    protected static ?string $navigationGroup = 'Questionnaire Viewer';

    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static string $view = 'feedback.show';
}
