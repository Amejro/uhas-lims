<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Inventory;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\ProductVariantRelationManager;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('unit')
                    ->options(
                        [
                            'g' => 'g',
                            'mL' => 'mL',
                        ]
                    )->required(),
                Forms\Components\Select::make('storage_location_id')->relationship('storageLocation', 'id')->required(),
                Forms\Components\Textarea::make('description'),
        ,



                Section::make('Ingredient')
                    ->description('provide the list of ingredients and the exact quantities required to produce one unit of your base size product')
                    ->schema([
                        Repeater::make('ingredient')->label('')->schema([


                            Select::make('ingredient')
                                ->options(function () {
                                    return Inventory::all()->pluck('name', 'id');
                                })
                                ->live()

                                ->required(),

                            TextInput::make('quantity')->numeric()->live()
                                ->suffix(function (Get $get) {
                                    $ingredient = Inventory::find((int) $get('ingredient'));

                                    if ($ingredient) {
                                        if ($ingredient->unit == 'L') {
                                            return 'mL';
                                        }

                                        if ($ingredient->unit == 'Kg') {
                                            return 'g';
                                        }

                                        return $get('ingredient');
                                    }
                                })
                                ->reactive()
                                ->disabled(function (Get $get) {
                                    return !$get('ingredient');
                                })
                                ->required(),

                        ])->columns(2)


                        // ->addAction(function (Get $get, Set $set, $record) {
                        //     if (!$record) {
                        //         $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                        //         $set('total_quantity', $total);
                        //     }$total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                        //     $set('restock_quantity', $total);

                        // })->deleteAction(function (Action $action) {
                        //     $action->after(function (Get $get, Set $set, $record) {
                        //         if (!$record) {
                        //             $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                        //             $set('total_quantity', $total);
                        //         }$total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                        //         $set('restock_quantity', $total);
                        //     });
                        // })->columnSpanFull()

                        ,
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
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
            ProductVariantRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
