<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\PaymentRecord;
use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class PaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue';

    protected static ?int $sort = 2;

    public ?string $filter = 'today';

    public static function canView(): bool
    {
        if (auth()->user()->hasRole('Supper Administrator') || auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Accountant')) {
            return true;
        }
        return false;
        
        
    }


    protected function getData(): array
    {
        // Determine the date range and grouping interval based on the active filter
        [$start, $end, $groupingInterval] = match ($this->filter) {
            'today' => [now()->startOfDay(), now(), 'perHour'],
            'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay(), 'perHour'],
            'week' => [now()->startOfWeek(), now(), 'perDay'],
            'month' => [now()->startOfMonth(), now(), 'perDay'],
            'year' => [now()->startOfYear(), now(), 'perMonth'],
            default => [now()->startOfDay(), now(), 'perHour'], // Fallback to "Today"
        };

        // Generate the trend data based on the date range and grouping interval
        $trend = Trend::model(PaymentRecord::class)
                    ->between($start, $end)
            ->{$groupingInterval}()
                ->sum('amount');

        // Format labels and data
        $labels = $trend->map(fn($item) => $this->formatDate($item->date, $groupingInterval))->toArray();
        $data = $trend->map(fn($item) => $item->aggregate)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (GH₵)',
                    'data' => $data,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    // Helper method to format dates dynamically
    private function formatDate(string $date, string $groupingInterval): string
    {
        $parsedDate = Carbon::parse($date);

        return match ($groupingInterval) {
            'perHour' => $parsedDate->format('H:i'), // Hourly format for Today/Yesterday
            'perDay' => $parsedDate->format('d M'), // Daily format for Week/Month
            'perMonth' => $parsedDate->format('M'), // Monthly format for Year
            default => $parsedDate->toDateString(),
        };
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'yesterday' => 'Yesterday',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }
}

