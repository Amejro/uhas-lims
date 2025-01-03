<?php

namespace App\Filament\Resources\ProductionBatcheResource\Pages;

use App\Filament\Resources\ProductionBatcheResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductionBatche extends ViewRecord
{
    protected static string $resource = ProductionBatcheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
