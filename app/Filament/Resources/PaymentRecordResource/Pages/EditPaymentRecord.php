<?php

namespace App\Filament\Resources\PaymentRecordResource\Pages;

use App\Filament\Resources\PaymentRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentRecord extends EditRecord
{
    protected static string $resource = PaymentRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
