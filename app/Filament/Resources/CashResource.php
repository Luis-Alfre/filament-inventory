<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CashResource\Pages;
use App\Filament\Resources\CashResource\RelationManagers;
use App\Models\Cash;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashResource extends Resource
{
    protected static ?string $model = Cash::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'System Management';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
            ->schema([
            TextInput::make('name')->required(),
            TextInput::make('full_money')->required()->numeric(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable(),
                TextColumn::make('full_money')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCashes::route('/'),
            'create' => Pages\CreateCash::route('/create'),
            'edit' => Pages\EditCash::route('/{record}/edit'),
        ];
    }
}
