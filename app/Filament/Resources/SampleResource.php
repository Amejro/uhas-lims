<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Test;
use Filament\Tables;
use App\Models\Sample;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Producer;
use Filament\Forms\Form;
use App\Models\DosageForm;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\SampleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SampleResource\RelationManagers;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;
use App\Filament\Resources\SampleResource\RelationManagers\TestsRelationManager;

class SampleResource extends Resource
{

    protected static ?string $model = Sample::class;

    // protected static ?string $recordTitleAttribute = 'number';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'fontisto-test-bottle';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([



                Section::make()

                    ->schema([
                        TextInput::make('name')
                            ->label('Product name')
                            ->hidden(function () {
                                return auth()->user()->is_technician();
                            })
                            ->required(),
                        Select::make('dosage_form_id')
                            ->relationship('dosageForm', 'name')
                            ->required(),
                        Select::make('tests')
                            ->multiple()
                            ->relationship('tests', 'name')
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                $sum = Test::select('price')
                                    ->whereIn('id', $get('tests'))
                                    ->get();

                                $set('total_cost', $sum->sum('price'));
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric(),
                        TextInput::make('batch_number')
                            ->required(),
                        TextInput::make('serial_code')->readOnly(),
                        TextInput::make('total_cost')
                            ->live()
                            ->readOnly()
                            ->numeric(),
                    ])->columns(2),

                Section::make()

                    ->schema([
                        TagsInput::make('indication')->reorderable()
                            ->placeholder('Enter indications'),

                        TagsInput::make('active_ingredient')
                            ->placeholder('Enter ingredient')
                        ,

                        TagsInput::make('dosage')
                            ->placeholder('Enter ingredient')
                            ->label('Dosing')
                        ,

                        DatePicker::make('date_of_manufacture')
                            ->required(),
                        DateTimePicker::make('expiry_date')
                            ->required(),
                    ])->columns(2),

                Section::make()

                    ->schema([
                        TextInput::make('delivered_by')
                            ->required(),
                        TextInput::make('deliverer_contact')
                            ->required(),

                            DatePicker::make('collection_date')
                            ->required(),
                        Select::make('storage_location_id')
                            ->relationship('storageLocation', 'room')
                            ->required(),

                        Select::make('producer_id')
                            ->relationship('producer', 'name')
                            ->createOptionForm(Producer::getForm())
                            ->hidden(function () {
                                return auth()->user()->is_technician();
                            })
                            ->required(),
                        Radio::make('status')
                            ->hidden(function ($record) {
                                if (!$record) {
                                    return true;
                                }

                            })
                            ->options(Status::class)
                            ->columns(3)
                            ->required(),

                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('serial_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                ->hidden(function () {
                    return auth()->user()->is_technician();
                })
                    ->searchable(),
                Tables\Columns\TextColumn::make('producer.name')
                ->hidden(function () {
                    return auth()->user()->is_technician();
                })
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dosageForm.name')
                    ->numeric()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('collection_date')
                    ->dateTime()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => static fn($state): bool => $state === 'collected',
                        'warning' => static fn($state): bool => $state === 'in_progress',
                        'success' => static fn($state): bool => $state === 'completed',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivered_by')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deliverer_contact')
                    ->searchable()->toggleable(isToggledHiddenByDefault: true),



                Tables\Columns\TextColumn::make('date_of_manufacture')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('storageLocation.id')
                    ->numeric()
                    ->sortable()->toggleable(isToggledHiddenByDefault: true),



                Tables\Columns\TextColumn::make('total_cost')
                    ->money('GHS')
                ,
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
                ActionGroup::make([
                    ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Action::make('Print report')
                        ->icon('heroicon-o-document-arrow-down')
                        ->url(fn(Sample $record) => route('samples.pdf.download', $record))
                        ->hidden(function () {
                            return !auth()->user()->is_admin();
                        })
                        ->openUrlInNewTab(),

                    Action::make('Recommendations')
                        ->icon('heroicon-o-hand-thumb-up')
                    // ->url(fn(Sample $record) => route('samples.pdf.download', $record))
                    // ->openUrlInNewTab()

                ]),
                ActivityLogTimelineTableAction::make('Activities')->hidden(function () {
                    return !auth()->user()->is_admin();
                }),

            ])
            // ->recordUrl(function (Model $record) {

            //     return Pages\EditSample::getUrl([$record->id])->hidden(function () {
            //         return !auth()->user()->is_admin();
            //     });

            // })
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
        ;
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



enum Status: string implements HasLabel
{
    case Collected = 'collected';
    case In_progress = 'in_progress';
    case Completed = 'completed';


    public function getLabel(): ?string
    {
        return $this->name;

    }

}