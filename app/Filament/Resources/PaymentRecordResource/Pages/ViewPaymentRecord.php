<?php

namespace App\Filament\Resources\PaymentRecordResource\Pages;

use App\Filament\Resources\PaymentRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentRecord extends ViewRecord
{
    protected static string $resource = PaymentRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
