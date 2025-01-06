<?php

namespace App\Filament\Widgets;

use App\Models\Sample;
use App\Models\Payment;
use App\Models\Producer;
use App\Models\SampleTest;
use App\Models\PaymentRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;



class statOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    // protected static ?int $sort = 1;
    protected static ?int $sort = 0;

    public static function canView(): bool
    {

        if (auth()->user()->hasRole('Supper Administrator') || auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Accountant')) {
            return true;
        }
        return false;

    }


    protected function getStats(): array
    {

        // $startDate = !is_null($this->filters['startDate'] ?? null)
        //     ? Carbon::parse($this->filters['startDate'])
        //     : now()->startOfMonth();

        // $endDate = !is_null($this->filters['endDate'] ?? null)
        //     ? Carbon::parse($this->filters['endDate'])
        //     : now();

        $startDate = ($this->filters['startDate'] ?? null) !== null
            ? Carbon::parse($this->filters['startDate'])
            : now()->startOfMonth();

        $endDate = ($this->filters['endDate'] ?? null) !== null
            ? Carbon::parse($this->filters['endDate'])
            : now();




        // Calculate the total revenue from payments
        $totalRevenue = PaymentRecord::whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $unrealizedpayment = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->sum('balance_due');

        $pendingPayments = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'pending')
            ->sum('total_amount');



        // Number formatting helper
        $formatNumber = function ($number) {
            if ($number < 1000) {
                return (string) number_format($number, 0);
            }
            if ($number < 1000000) {
                return number_format($number / 1000, 2) . 'k';
            }
            return number_format($number / 1000000, 2) . 'm';
        };



        return [
            // Total Revenue Stat
            Stat::make('Revenue', 'GH₵' . $formatNumber($totalRevenue))
                ->color('success'),

            Stat::make('Unrealized Payment', 'GH₵' . $formatNumber($unrealizedpayment))
                ->color('info'),

            Stat::make('Pending Payments', 'GH₵' . $formatNumber($pendingPayments))
                ->color('info'),
        ];

    }
}
