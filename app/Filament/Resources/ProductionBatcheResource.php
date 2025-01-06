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
use Illuminate\Support\Arr;
use App\Models\ProductVariant;
use App\Models\ProductionBatche;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\Context;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductionBatcheResource\Pages;
use App\Filament\Resources\ProductionBatcheResource\RelationManagers;

class ProductionBatcheResource extends Resource
{
    protected static ?string $model = ProductionBatche::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected $ingredientArray = [];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->live()
                            ->relationship('product', 'name')
                            ->required(),

                        Repeater::make('productionBatchLines')
                            ->relationship()
                            ->label('Product Variants')
                            ->schema(function (Get $get) {

                                return [
                                    Select::make('product_variant_id')
                                        ->label('Variant')
                                        ->options(fn(Get $get): Collection => ProductVariant::query()
                                            ->where('product_id', $get('../../product_id'))
                                            ->pluck('name', 'id'))

                                        ->afterStateUpdated(function (Get $get, Set $set) {

                                            $productVariant = ProductVariant::find($get('product_variant_id'));

                                            $product = $productVariant->product;


                                            array_map(function ($ingredient) use ($productVariant, $product, $set, $get) {
                                                // $ing = Inventory::find($ingredient['ingredient']);
                            
                                                $factor = $ingredient['quantity'] / $product?->base_size;



                                                // $set($ingredient['ingredient'], +$factor * $productVariant?->size);
                            


                                            }, $product->ingredient);
                                        })

                                        ->live(true)
                                        ->reactive()
                                        ->required(),

                                    TextInput::make('quantity')
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            // $set($get('total'), $get('quantity') * 2);
                            


                                            $productVariant = ProductVariant::find($get('product_variant_id'));

                                            $product = $productVariant->product;

                                            $variantData = array_map(function ($ingredient) use ($productVariant, $product, $set, $get, &$ingredientArray) {
                                                // $ing = Inventory::find($ingredient['ingredient']);
                            
                                                $factor = $ingredient['quantity'] / $product?->base_size;

                                                // $set($ingredient['ingredient'], $factor * $productVariant?->size);
                            
                                                $totalSize = $factor * $productVariant?->size;

                                                Context::push('ingredientArray', [
                                                    'ingredient' => $ingredient['ingredient'],
                                                    'qty' => $totalSize * $get('quantity')

                                                ]);



                                            }, $product->ingredient);



                                        })



                                        ->live()
                                        ->numeric(),

                                ];

                            })

                            ->columns(3)

                            ->addAction(function (Get $get, Set $set, $record) use (&$ingredientArray) {





                                $repeaterData = collect($get('productionBatchLines'));

                                if ($repeaterData->first()['product_variant_id']) {

                                    $repeaterData->map(function ($variant) use ($get, $set) {

                                        $productVariant = ProductVariant::find((int) $variant['product_variant_id']);

                                        $product = $productVariant?->product;

                                        array_map(function ($ingredient) use ($productVariant, $product, $set) {
                                            // $ing = Inventory::find($ingredient['ingredient']);
                    
                                            $factor = $ingredient['quantity'] / $product?->base_size;

                                            $set($ingredient['ingredient'], +$factor * $productVariant?->size);

                                        }, $product->ingredient);


                                    });
                                }
                            })
                            ->columnSpanFull(),



                        Forms\Components\Section::make()

                            ->description('Product Ingredients')
                            ->schema(function (Get $get) {

                                if ($get('product_id') === null) {
                                    return [];
                                }

                                $product = Product::find($get('product_id'));

                                if ($product === null) {
                                    return [];
                                }

                                $compo = array_map(
                                    function ($ingredient) {
                                        $ing = Inventory::find($ingredient['ingredient']);

                                        return TextInput::make($ingredient['ingredient'])
                                            ->label(function () use ($ing) {
                                                return $ing->name;
                                            })

                                            ->default(function () use ($ing) {


                                                return $ing->total_quantity / 1000;
                                            })
                                            ->inlineLabel()
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->reactive()
                                            ->live()
                                        ;
                                    },
                                    $product->ingredient
                                )
                                ;
                                return $compo;
                                // dd();
                            })
                            ->reactive()

                            ->hidden(fn(?Get $get) => $get('product_id') === null),
                    ])
                    ->columnSpan(['lg' => 2])
                ,

                Section::make()
                    ->schema([
                        // Forms\Components\TextInput::make('batch_code')
                        //     ->required(),

                        Forms\Components\TextInput::make('total_quantity')
                            ->live()
                            ->afterStateUpdated(function (Get $get) {

                                // $Array = Context::all();
                                // dd($Array);
                    
                            })
                            ->reactive()
                            ->numeric(),
                        // Forms\Components\TextInput::make('status')
                        //     ->required(),

                        Forms\Components\Section::make()

                            ->description('Product Ingredients')
                            ->schema(function (Get $get) {

                                if ($get('product_id') === null) {
                                    return [];
                                }

                                $product = Product::find($get('product_id'));

                                if ($product === null) {
                                    return [];
                                }

                                $compo = array_map(
                                    function ($ingredient) {
                                        $ing = Inventory::find($ingredient['ingredient']);

                                        return Forms\Components\Placeholder::make($ingredient['ingredient'])
                                            ->label(function () use ($ing) {
                                                return $ing->name;
                                            })
                                            ->content(function () use ($ing) {


                                                return $ing->total_quantity / 1000 . ' ' . $ing->unit;
                                            })
                                            ->inlineLabel()
                                            ->reactive()
                                            ->live()
                                        ;
                                    },
                                    $product->ingredient
                                )
                                ;
                                return $compo;
                                // dd();
                            })
                            ->reactive()

                            ->hidden(fn(?Get $get) => $get('product_id') === null),
                    ])->columnSpan(['lg' => 1]),





            ])
            ->columns(3)
        ;
    }




    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('batch_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductionBatches::route('/'),
            'create' => Pages\CreateProductionBatche::route('/create'),
            'view' => Pages\ViewProductionBatche::route('/{record}'),
            'edit' => Pages\EditProductionBatche::route('/{record}/edit'),
        ];
    }
}
