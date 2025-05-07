<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseOptionsResource\Pages;
use App\Models\ResponseOption;
use Filament\Forms;
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

class ResponseOptionResource extends Resource
{
    protected static ?string $model = ResponseOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('response_set_id')
                    ->required()
                    ->label('Response set')
                    ->relationship('responseSet', 'name'),
                TextInput::make('value')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('order')
                    ->label('Order')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ResponseSet.name')
                ->label('Response set')
                ->searchable()
                ->sortable(),
                TextColumn::make('value'),
                TextColumn::make('label'),
                TextColumn::make('order'),
            ])
            ->filters([
                TrashedFilter::make('trashed')
                    ->label('Deleted Response Options')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResponseOptions::route('/'),
            'create' => Pages\CreateResponseOptions::route('/create'),
            'edit' => Pages\EditResponseOptions::route('/{record}/edit'),
        ];
    }
}
