<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Services\ResultsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'questionnaireAttempts';

    protected static ?string $title = 'Assessment History';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Assessment Details')
                    ->schema([
                        Forms\Components\Select::make('questionnaire_id')
                            ->relationship('questionnaire', 'name')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('session_id')
                            ->disabled()
                            ->columnSpan(2),
                    ])
                    ->columns(3),
                Forms\Components\Section::make('Timestamps')
                    ->schema([
                        Forms\Components\DateTimePicker::make('started_at')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('completed_at')
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('session_id')
            ->columns([
                Tables\Columns\TextColumn::make('questionnaire.name')
                    ->label('Assessment')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->completed_at ? 'completed' : 'in_progress')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'in_progress',
                    ])
                    ->formatStateUsing(fn (string $state): string => 
                        $state === 'completed' ? 'Completed' : 'In Progress'
                    ),
                Tables\Columns\TextColumn::make('riasec_code')
                    ->label('RIASEC Code')
                    ->getStateUsing(function ($record) {
                        if (!$record->completed_at || $record->responses->isEmpty()) {
                            return '—';
                        }
                        try {
                            $resultsService = new ResultsService();
                            $results = $resultsService->calculateResults($record);
                            return $results['three_letter_code'] ?? '—';
                        } catch (\Exception $e) {
                            return 'Error';
                        }
                    })
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('responses_count')
                    ->label('Responses')
                    ->counts('responses')
                    ->sortable(),
                Tables\Columns\TextColumn::make('started_at')
                    ->label('Started')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Completed')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('completed')
                    ->options([
                        '1' => 'Completed',
                        '0' => 'In Progress',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['value'])) {
                            return $query;
                        }
                        
                        return $data['value'] === '1' 
                            ? $query->whereNotNull('completed_at')
                            : $query->whereNull('completed_at');
                    }),
            ])
            ->headerActions([
                // Remove create action - attempts should only be created through the frontend
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('view_results')
                    ->label('View Results')
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn ($record) => $record->completed_at ? route('feedback.show', $record) : null)
                    ->visible(fn ($record) => $record->completed_at !== null)
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
