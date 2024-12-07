<?php

namespace App\Filament\Resources\PaymentRecordResource\Pages;

use App\Filament\Resources\PaymentRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentRecords extends ListRecords
{
    protected static string $resource = PaymentRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
