<?php

namespace App\Filament\Widgets;

use App\Models\Producer;
use App\Models\Sample;
use App\Models\SampleTest;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class statOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Samples', Sample::query()->count())
                ->description('All registed samples')
                ->icon('fontisto-test-bottle'),
            // ->color('success'),

            // Stat::make('Tests', SampleTest::query()->count())
            //     ->description('Total tests conducted')
            //     ->icon('heroicon-o-beaker'),
            // ->color('success'),

            Stat::make('Producer', Producer::query()->count())
                ->description('Total producers')
                ->icon('heroicon-o-building-office-2'),
        ];
    }
}
