<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\TraitDomainConfig;
use App\Filament\Pages\QuestionnaireViewer;
use App\Filament\Resources\TraitFeedbackTemplateResource\Pages;
use App\Filament\Resources\TraitFeedbackTemplateResource\RelationManagers;
use App\Models\TraitFeedbackTemplate;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TraitFeedbackTemplateResource extends Resource
{
    protected static ?string $model = TraitFeedbackTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'Trait & Domain Config';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('domain_id')
                ->label('Domain')
                ->relationship('domain', 'name')
                ->required(),
                Select::make('role')
                ->label('Role')
                ->required()
                ->options([
                    'primary' => 'Primary',
                    'supporting' => 'Supporting',
                    'modulating' => 'Modulating',
                ]),
                Textarea::make('description')
                ->label('Description')
                ->required()
                ->rows(5),
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
                TextColumn::make('role')
                ->label('Role')
                ->searchable()
                ->sortable(),
                TextColumn::make('description')
                ->label('Description')
                ->limit(50)
                ->tooltip(fn ($record) => $record->description),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make('Deleted items')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTraitFeedbackTemplates::route('/'),
            'create' => Pages\CreateTraitFeedbackTemplate::route('/create'),
            'edit' => Pages\EditTraitFeedbackTemplate::route('/{record}/edit'),
        ];
    }
}
