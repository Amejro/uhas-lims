<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Payment;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\PaymentResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPayments extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(
                PaymentResource::getEloquentQuery()->where('status', '!=', 'pending')
            )
            ->defaultSort('updated_at', 'desc')
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('serial_code'),
                // TextColumn::make('total_amount')
                //     ->label('Amount due')
                //     ->money('GHS'),
                TextColumn::make('amount_paid')->money('GHS'),

                // TextColumn::make('balance_due')
                //     ->money('GHS'),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => static fn($state): bool => $state === 'pending',
                        'warning' => static fn($state): bool => $state === 'part payment',
                        'success' => static fn($state): bool => $state === 'paid',
                    ]),
                TextColumn::make('user.name')
                    ->label('Received by')
                ,

                // TextColumn::make('sample.name')
                //     ->label('Product Name')
                // ,
                TextColumn::make('updated_at')
                    ->label('Date')
                    ->dateTime(),
            ])
            ->actions([
                Action::make('open')
                    ->url(fn(Payment $record): string => PaymentResource::getUrl('edit', ['record' => $record])),
            ]);
        ;
    }
}
