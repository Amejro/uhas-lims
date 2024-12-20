<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Sample;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\SampleResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSamples extends BaseWidget
{

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        if (auth()->user()->hasRole('Accountant')) {
            return false;
        }
        return true;
        
        
    }

    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                SampleResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('serial_code')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('producer.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dosageForm.name')
                    ->numeric()
                    //     ->sortable()->toggleable(isToggledHiddenByDefault: true),
                    // TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                // TextColumn::make('collection_date')
                //     ->dateTime()
                //     ->sortable()->toggleable(isToggledHiddenByDefault: true),

                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => static fn($state): bool => $state === 'collected',
                        'warning' => static fn($state): bool => $state === 'in_progress',
                        'success' => static fn($state): bool => $state === 'completed',
                    ])
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->url(fn(Sample $record): string => SampleResource::getUrl('edit', ['record' => $record])),
            ]);
        ;
    }
}
