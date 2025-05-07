<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\ResponsesRelationManagerResource\RelationManagers\ResponsesRelationManager;
use App\Models\Question;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('domain_id')
                    ->label('Domain')
                    ->relationship('domain', 'name')
                    ->required(),
                Select::make('questionnaire_id')
                    ->label('Questionnaire')
                    ->relationship('questionnaire', 'name')
                    ->required(),
                Select::make('response_set_id')
                ->label('Response set')
                ->Relationship('responseSet', 'name'),
                TextInput::make('question_text')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('domain.name')
                    ->label('Domain')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('questionnaire.name')
                    ->label('Questionnaire')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('responseSet.name')
                    ->label('Response set'),
                TextColumn::make('question_text')
                    ->label('Question'),
            ])
            ->filters([
                TrashedFilter::make('trashed')
                    ->label('Deleted questions')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
