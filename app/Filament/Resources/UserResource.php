<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
            ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255),
                TextInput::make('email')
                ->label('Email Address')
                ->required()
                ->maxLength(255),
                TextInput::make('password')
                ->required(fn(Page $livewire):bool => $livewire instanceof CreateRecord)
                ->password()
                ->minLength(8)
                ->same('passwordConfirmation')
                ->dehydrated(fn ($state) => filled($state))
                ->dehydrateStateUsing(fn ($state)=> Hash::make($state)),
                TextInput::make('passwordConfirmation')
                ->password()
                ->label('Password Confirmation')
                ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
                ->minLength(8)
                ->dehydrated(false),
                Select::make('roles')
                    ->relationship('roles', 'name')->preload()
                    ->multiple(),

            ])
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable(),
                TextColumn::make('roles.name')->sortable(),
                TextColumn::make('email')->sortable()->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
