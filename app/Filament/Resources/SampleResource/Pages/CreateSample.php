<?php

namespace App\Filament\Resources\SampleResource\Pages;

use App\Models\Test;
use Filament\Actions;
use App\Models\Sample;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Producer;
use App\Models\DosageForm;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\SampleResource;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Pages\CreateRecord\Concerns\HasWizard;


class CreateSample extends CreateRecord
{

    use HasWizard;
    protected static string $resource = SampleResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('Product information')
                ->icon('heroicon-o-beaker')
                ->description('Collect product information')
                ->schema([
                    TextInput::make('name')
                        ->label('Product name')
                        ->required(),
                    Select::make('dosage_form_id')
                        ->relationship('dosageForm', 'name')
                        ->required(),
                    DatePicker::make('collection_date')
                        ->required(),
                    TextInput::make('quantity')
                        ->label('Number of products')
                        ->required()
                        ->numeric(),
                    TextInput::make('batch_number'),
                    TagsInput::make('indication')->reorderable()
                        ->placeholder('Enter indications'),

                    TagsInput::make('active_ingredient')
                        ->placeholder('Enter ingredient'),
                        
                    TagsInput::make('dosage')->label('Dosing')
                        ->placeholder('Enter dosing')
                    ,
                    DatePicker::make('date_of_manufacture'),
                    DatePicker::make('expiry_date')->label('Date of expiry'),

                ])->columns(2),

            Step::make('Manufacturer')
                ->icon('heroicon-o-building-office-2')
                ->description('Collect manufacturer information')
                ->schema([

                    Select::make('producer_id')
                        ->label('Manufacturer')
                        ->relationship('producer', 'name')
                        ->createOptionForm(Producer::getForm())
                        ->required(),

                    TextInput::make('delivered_by')
                        ->required(),
                    TextInput::make('deliverer_contact')
                        ->label('deliverer`s contact')
                        ->required(),

                ])->columns(2),

            Step::make('Test information')
                ->icon('heroicon-o-eye-dropper')
                ->description('Select tests to be conducted')
                ->schema([
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

                    // TextInput::make('serial_code'),
                    TextInput::make('total_cost')
                        ->live()
                        ->readOnly()
                        ->prefix('GH₵')
                        ->numeric(),
                    Select::make('storage_location_id')
                        ->relationship('storageLocation', 'room')
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
                ])->columns(2)
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