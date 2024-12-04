<?php

namespace App\Filament\Resources\SampleResource\Pages;

use App\Filament\Resources\SampleResource;
use App\Models\Sample;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListSamples extends ListRecords
{
    protected static string $resource = SampleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make(),
            'Collected' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'collected'))->badge(Sample::query()->where('status', '=', 'collected')->count()),

            'In progress' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'in_progress'))->badge(Sample::query()->where('status', '=', 'in_progress')->count()),

            'Completed' => Tab::make()->modifyQueryUsing(fn(Builder $query) => $query->where('status', '=', 'completed'))->badge(Sample::query()->where('status', '=', 'completed')->count()),

        ];

    }
}
