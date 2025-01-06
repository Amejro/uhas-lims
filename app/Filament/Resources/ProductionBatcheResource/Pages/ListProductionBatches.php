<?php

namespace App\Filament\Resources\ProductionBatcheResource\Pages;

use App\Filament\Resources\ProductionBatcheResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductionBatches extends ListRecords
{
    protected static string $resource = ProductionBatcheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
