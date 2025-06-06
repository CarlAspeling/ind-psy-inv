<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseSetResource\Pages;
use App\Filament\Resources\ResponseSetResource\Pages\CreateResponseSet;
use App\Filament\Resources\ResponseSetResource\Pages\EditResponseSet;
use App\Filament\Resources\ResponseSetResource\Pages\ListResponseSets;
use App\Models\ResponseSet;
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

class ResponseSetResource extends Resource
{
    protected static ?string $model = ResponseSet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Response Set Name'),
            ])
            ->filters([
                TrashedFilter::make('trashed')
                    ->label('Deleted Response Sets'),
            ])
            ->actionsAlignment('left')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
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
            'index' => ListResponseSets::route('/'),
            'create' => CreateResponseSet::route('/create'),
            'edit' => EditResponseSet::route('/{record}/edit'),
        ];
    }
}
