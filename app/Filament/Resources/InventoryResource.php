<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Notifications\Collection;
use Filament\Tables;
use ReflectionClass;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Inventory;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Livewire\Component as Livewire;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\InventoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InventoryResource\RelationManagers;
use function Livewire\on;


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
                                ->required(),
                            Forms\Components\Select::make('unit')->live()
                                ->options(
                                    [

                                        'g' => 'g',
                                        'kg' => 'kg',
                                        'mL' => 'mL',
                                        'L' => 'L',
                                    ]
                                )

                            // ->afterStateUpdated(function (Component $component, Get $get) {




                            //     $comp = $component->getContainer()->getFlatFields();

                            //     foreach ($comp['item_variant']->getChildComponents() as $index => $item) {

                            //         if ($index % 2 === 0) {

                            //             $reflection = new ReflectionClass($item);

                            //             $property = $reflection->getProperty('suffixLabel');

                            //             $property->setAccessible(true);

                            //             $property->setValue($item, $get('unit'));
                            //         }



                            //     }

                            // })
                            ,
                            Forms\Components\Textarea::make('description')
                                ->columnSpanFull(),


                            Forms\Components\TextInput::make('reorder_level')
                                ->numeric(),
                            Forms\Components\DatePicker::make('expiry_date')
                                ->required(),

                            Forms\Components\Select::make('storage_location_id')
                                ->relationship('storageLocation', 'id')
                                ->required(),
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'name')
                                ->required(),


                            Repeater::make('item_variant')
                                ->label('Item Variant(s)')
                                ->schema([
                                    TextInput::make('variant')
                                        ->live()
                                        ->suffix(function (Get $get) {
                                            return $get('../../unit');

                                        })
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            $set('sub_total', $get('quantity') * $get('variant'));

                                        })
                                        ->numeric()
                                        ->required(),

                                    TextInput::make('quantity')
                                        ->numeric()
                                        ->live()
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            $set('sub_total', $get('quantity') * $get('variant'));

                                        })
                                        ->required(),

                                    TextInput::make('sub_total')
                                        ->numeric()
                                        ->disabled()
                                        ->suffix(function (Get $get) {
                                            return $get('../../unit');
                                        })

                                        ->required(),
                                ])

                                ->columns(3)
                                ->addAction(function (Get $get, Set $set) {
                                    $total = collect($get('item_variant'))->values()->pluck('sub_total')->sum();

                                    $set('total_quantity', $total);

                                })


                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make([
                        Forms\Components\TextInput::make('total_quantity')
                            ->suffix(function (Get $get) {
                                return $get('unit');

                            })
                            ->live()
                            ->disabled()
                            ->numeric(),
                        Forms\Components\TextInput::make('status')
                            ->required(),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reorder_level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_variant')
                    ->boolean(),
                Tables\Columns\TextColumn::make('storageLocation.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
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
            //
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
