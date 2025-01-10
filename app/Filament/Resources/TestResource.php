<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Test;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Inventory;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestResource\RelationManagers;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static ?string $navigationGroup = 'Lab Management';

    protected static ?string $navigationIcon = 'heroicon-o-beaker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('GH₵'),

                Section::make('reagent_kit')
                    ->description('Provide the list of reagents and their quantities required for this test')
                    ->schema([
                        Repeater::make('reagent_kit')->label('')->schema([

                            Select::make('reagent_kit')
                                ->options(function () {
                                    return Inventory::all()->pluck('name', 'id');
                                })
                                ->live()

                                ->required(),

                            TextInput::make('quantity')->numeric()->live()
                                ->suffix(function (Get $get) {
                                    $ingredient = Inventory::find((int) $get('reagent_kit'));

                                    if ($ingredient) {
                                        if ($ingredient->unit == 'L') {
                                            return 'mL';
                                        }

                                        if ($ingredient->unit == 'Kg') {
                                            return 'g';
                                        }

                                        // return $get('ingredient');
                                    }
                                })
                                ->reactive()
                                ->disabled(function (Get $get) {
                                    return !$get('reagent_kit');
                                })
                                ->required(),

                        ])->columns(2)
                        ,
                    ])

            ])
            ->columns(2)
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('GHS')
                ,
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created by')
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make(),
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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'view' => Pages\ViewTest::route('/{record}'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}
