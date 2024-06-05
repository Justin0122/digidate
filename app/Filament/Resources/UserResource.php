<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')
                    ->rules(['required', 'string', 'max:255']),

                Forms\Components\TextInput::make('lastname')
                    ->rules(['required', 'string', 'max:255']),

                Forms\Components\TextInput::make('password')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->rules(['string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/'])
                    ->password()
                    ->autocomplete('password'),

                Forms\Components\TextInput::make('email')
                    ->rule('unique:users,email', fn () => match ($form->getOperation()) {
                        'create' => true,
                        default => false,
                    })
                    ->rules(['required', 'string', 'email', 'max:255'])
                    ->email(),
                Forms\Components\Checkbox::make('admin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->state(fn ($record) => ! is_null($record->email_verified_at))
                    ->label('Verified')
                    ->boolean(),
                Tables\Columns\CheckboxColumn::make('admin')
                    ->disabled(fn (User $record) => $record->is(\Auth::user()) ||
                        ! $record->possibleAdmin(),
                    ),
            ])
            ->filters([
                Tables\Filters\Filter::make('email_verified_at')
                    ->query(fn (Builder $query) => $query->whereNotNull('email_verified_at')),
                Tables\Filters\Filter::make('admin')
                    ->query(fn (Builder $query) => $query->where('admin', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
