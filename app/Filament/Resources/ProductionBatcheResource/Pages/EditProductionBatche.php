<?php

namespace App\Filament\Resources\ProductionBatcheResource\Pages;

use App\Filament\Resources\ProductionBatcheResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionBatche extends EditRecord
{
    protected static string $resource = ProductionBatcheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
