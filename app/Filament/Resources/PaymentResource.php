<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sample;
use App\Models\Payment;
use Filament\Forms\Form;

use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Filament\Resources\PaymentResource\RelationManagers\PaymentRecordsRelationManager;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $recordTitleAttribute = 'serial_code';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $titleAttribute = 'title';
    protected static ?string $placeHoder = 'payment';





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('amount_paid')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('serial_code')
                    ->required(),
                Forms\Components\TextInput::make('balance_due')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Select::make('sample_id')
                    ->relationship('sample', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serial_code'),
                TextColumn::make('total_amount')
                    ->label('Amount due')
                    ->money('GHS'),
                TextColumn::make('amount_paid')->money('GHS'),

                TextColumn::make('balance_due')
                    ->money('GHS'),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => static fn($state): bool => $state === 'pending',
                        'warning' => static fn($state): bool => $state === 'part payment',
                        'success' => static fn($state): bool => $state === 'paid',
                    ]),

                TextColumn::make('sample.name')
                    ->label('Product Name')
                ,
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make('Product Details')
                    ->schema([
                        TextEntry::make('sample.name')->label('Product Name'),
                        TextEntry::make('total_amount')->label('Amount Due')->money('GHS'),

                        TextEntry::make('amount_paid')->label('Amount Paid')->money('GHS'),

                        TextEntry::make('balance_due')->label('Balance Due')->money('GHS'),
                        TextEntry::make('serial_code')->label('Serial Code'),

                        TextEntry::make('status')->label('Payment Status'),

                    ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            PaymentRecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }


    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return PaymentResource::getUrl('view', ['record' => $record]);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Product name' => Sample::find($record->sample_id)->name,
            'Amount Due' => 'GH₵' . number_format($record->total_amount, 2, '.', ',')
        ];
    }


}
