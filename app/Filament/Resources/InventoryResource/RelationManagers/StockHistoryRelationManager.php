<?php

namespace App\Filament\Resources\InventoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Set;

class StockHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'stockHistories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('action')
                    ->maxLength(255),
                Forms\Components\TextInput::make('total_quantity')->suffix(function (RelationManager $livewire) {
                    return $livewire->getOwnerRecord()->unit;
                }),
                Forms\Components\TextInput::make('user_id'),
                Forms\Components\DatePicker::make('created_at'),

                Repeater::make('item_variant')
                    ->label('Item Variant(s)')
                    ->schema([
                        TextInput::make('variant')
                            ->live()

                            ->suffix(function (RelationManager $livewire) {
                                return $livewire->getOwnerRecord()->unit;
                            })
                            ->numeric()
                            ->required(),

                        TextInput::make('quantity')
                            ->numeric()
                            ->live()
                            ->required(),
                    ])->columns(2),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action')
            ->columns([
                Tables\Columns\TextColumn::make('action'),
                Tables\Columns\TextColumn::make('total_quantity')->suffix(function (RelationManager $livewire) {
                    return $livewire->getOwnerRecord()->unit;
                }),
                Tables\Columns\TextColumn::make('user.name')->label('By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])

            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
