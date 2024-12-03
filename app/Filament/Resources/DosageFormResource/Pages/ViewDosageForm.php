<?php

namespace App\Filament\Resources\DosageFormResource\Pages;

use App\Filament\Resources\DosageFormResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDosageForm extends ViewRecord
{
    protected static string $resource = DosageFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
