<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sample;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SampleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SampleResource\RelationManagers;
use App\Filament\Resources\SampleResource\RelationManagers\TestsRelationManager;

class SampleResource extends Resource
{
    protected static ?string $model = Sample::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('collection_date')
                    ->required(),
                // Forms\Components\TextInput::make('active_ingredient'),
                Forms\Components\TagsInput::make('active_ingredient')
                    ->placeholder('Enter ingredient')
                ,

                Forms\Components\TextInput::make('delivered_by')
                    ->required(),
                Forms\Components\TextInput::make('deliverer_contact')
                    ->required(),
                // Forms\Components\TextInput::make('indication'),

                Forms\Components\TagsInput::make('indication')->columnSpanFull()->reorderable()
                    ->placeholder('Enter indications'),

                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('dosage'),
                Forms\Components\DateTimePicker::make('date_of_manufacture')
                    ->required(),
                Forms\Components\DateTimePicker::make('expiry_date')
                    ->required(),
                Forms\Components\TextInput::make('batch_number')
                    ->required(),
                Forms\Components\TextInput::make('serial_code'),
                Forms\Components\Select::make('storage_location_id')
                    ->relationship('storageLocation', 'id')
                    ->required(),
                Forms\Components\Select::make('dosage_form_id')
                    ->relationship('dosageForm', 'name')
                    ->required(),
                // Forms\Components\Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->required(),
                Forms\Components\Select::make('producer_id')
                    ->relationship('producer', 'name')
                    ->required(),

                Forms\Components\Select::make('tests')
                    ->multiple()
                    ->relationship('tests', 'name')
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('total_cost')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('collection_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('active_ingredient')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivered_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deliverer_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('indication')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dosage')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_manufacture')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('batch_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('storageLocation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dosageForm.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('producer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            TestsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSamples::route('/'),
            'create' => Pages\CreateSample::route('/create'),
            'view' => Pages\ViewSample::route('/{record}'),
            'edit' => Pages\EditSample::route('/{record}/edit'),
        ];
    }
}
