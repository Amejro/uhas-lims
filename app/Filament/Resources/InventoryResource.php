<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use ReflectionClass;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Inventory;
use function Livewire\on;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Livewire\Component as Livewire;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Filament\Notifications\Collection;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\InventoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Filament\Resources\InventoryResource\RelationManagers\StockHistoryRelationManager;


class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make()

                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()->readOnly(function ($record) {
                                    return $record;
                                }),
                            Forms\Components\Select::make('unit')->live()
                                ->options(
                                    [
                                        'kg' => 'kg',
                                        'L' => 'L',
                                    ]
                                ),
                            Forms\Components\Textarea::make('description')->columnSpanFull()->readOnly(function ($record) {
                                return $record;
                            }),
                            Forms\Components\DatePicker::make('expiry_date')->required()->readOnly(function ($record) {
                                return $record;
                            }),
                            Forms\Components\Select::make('storage_location_id')->relationship('storageLocation', 'id')->required(),

                            Repeater::make('item_variant')->label('Item Variant(s)')->schema([
                                TextInput::make('variant')->live()->suffix(function (Get $get) {
                                    return $get('../../unit');
                                })->afterStateUpdated(function (Set $set, Get $get) {
                                    $set('sub_total', $get('quantity') * $get('variant'));
                                })->numeric()
                                    ->live(true)
                                    ->required(),

                                TextInput::make('quantity')->numeric()->live(true)->afterStateUpdated(function (Set $set, Get $get) {
                                    $set('sub_total', $get('quantity') * $get('variant'));
                                })->required(),

                                TextInput::make('sub_total')->numeric()->disabled()->suffix(function (Get $get) {
                                    return $get('../../unit');
                                })->required(),

                            ])->columns(3)
                                ->addAction(function (Get $get, Set $set, $record) {
                                    if (!$record) {
                                        $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                                        $set('total_quantity', $total);
                                    }

                                    $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();

                                    $set('restock_quantity', $total);

                                })->deleteAction(function (Action $action) {
                                    $action->after(function (Get $get, Set $set, $record) {
                                        if (!$record) {
                                            $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                                            $set('total_quantity', $total);
                                        }$total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();
                                        $set('restock_quantity', $total);
                                    });
                                })->columnSpanFull(),

                        ])->columns(2),

                    Section::make([
                        Forms\Components\TextInput::make('total_quantity')
                            ->label(function ($record) {
                                return $record ? 'Available Quantity' : 'Total Quantity';
                            })

                            // ->state(function ($record) {
                            //     if ($record) {
                            //         return $record-> total_quantity / 1000;
                            //     }

                            // })
                            ->suffix(function (Get $get) {
                                return $get('unit');

                            })
                            ->live()
                            ->readOnly()
                            ->numeric(),

                        Forms\Components\TextInput::make('reorder_level')
                            ->suffix(function (Get $get) {
                                return $get('unit');

                            })
                            ->numeric(),

                        Forms\Components\TextInput::make('restock_quantity')
                            ->suffix(function (Get $get) {
                                return $get('unit');

                            })
                            ->hidden(function ($record) {
                                return !$record;
                            })
                            ->live()
                            ->readOnly()
                            ->numeric(),


                    ])->grow(false),


                ])
            ])
            ->columns(1)
        ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_quantity')
                    ->state(function ($record) {
                        return $record->total_quantity / 1000;
                    })
                    ->suffix(function ($record) {
                        return $record->unit;
                    })
                    ->numeric(),
                Tables\Columns\TextColumn::make('reorder_level')
                    ->numeric()
                    ->suffix(function ($record) {
                        return $record->unit;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),

                Tables\Columns\TextColumn::make('storageLocation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created By')
                    ->searchable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            StockHistoryRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'view' => Pages\ViewInventory::route('/{record}'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
