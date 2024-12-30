<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ProductVariantRelationManager extends RelationManager
{
    protected static string $relationship = 'productVariant';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('size')
                    ->label(function (RelationManager $livewire) {
                        $unit = $livewire->getOwnerRecord()->unit;

                        if ($unit == 'g') {
                            return 'mass (g)';
                        }
                        if ($unit == 'mL') {
                            return 'volume (mL)';
                        }

                    })
                    ->suffix((function (RelationManager $livewire) {
                        return $livewire->getOwnerRecord()->unit;
                    }))
                    ->live(true)
                    ->afterStateUpdated(function (RelationManager $livewire, Get $get, Set $set) {
                        $productName = $livewire->getOwnerRecord()->name;

                        $set('name', $productName . ' ' . $get('size') . ' ' . $livewire->getOwnerRecord()->unit);

                    })
                    ->required()
                ,
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->suffix('GH₵')
                    ->required()
                ,

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(true)
                    ->readOnly()
                ,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
