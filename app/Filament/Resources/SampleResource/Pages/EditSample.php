<?php

namespace App\Filament\Resources\SampleResource\Pages;


use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SampleResource;


class EditSample extends EditRecord
{
    protected static string $resource = SampleResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}


