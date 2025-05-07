<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireResource\Pages;
use App\Filament\Resources\QuestionnaireResource\Pages\CreateQuestionnaire;
use App\Filament\Resources\QuestionnaireResource\Pages\EditQuestionnaire;
use App\Filament\Resources\QuestionnaireResource\Pages\ListQuestionnaires;
use App\Filament\Resources\QuestionnaireResource\RelationManagers;
use App\Filament\Resources\QuestionnaireResource\RelationManagers\QuestionsRelationManager;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireResource extends Resource
{
    protected static ?string $model = Questionnaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                TextInput::make('type')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description')
                    ->limit(50),
                TextColumn::make('type'),
                TextColumn::make('questions_count')
                    ->label('Questions')
                    ->counts('questions')
                    ->alignCenter(),
            ])
            ->filters([
                TrashedFilter::make('trashed')
                    ->label('Deleted questionnaires')
            ])
            ->actionsAlignment('left')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                   DeleteBulkAction::make(),
                   RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionnaires::route('/'),
            'create' => CreateQuestionnaire::route('/create'),
            'edit' => EditQuestionnaire::route('/{record}/edit'),
        ];
    }
}
