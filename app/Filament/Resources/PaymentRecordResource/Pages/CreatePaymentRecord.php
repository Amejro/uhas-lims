<?php

namespace App\Filament\Resources\PaymentRecordResource\Pages;

use App\Filament\Resources\PaymentRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentRecord extends CreateRecord
{
    protected static string $resource = PaymentRecordResource::class;
}