<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use Filament\Actions;
use App\Models\Payment;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\PaymentResource;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            Action::make('Receipt')
                ->icon('heroicon-o-ticket')
                ->url(fn(Payment $payment) => route('receipt.pdf.download', $payment))

                ->openUrlInNewTab()


                ->requiresConfirmation()
        ];
    }

    #[On('refreshForm')]
    public function refresh(): void
    {
    }
}
