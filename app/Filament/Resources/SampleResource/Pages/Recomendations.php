<?php

namespace App\Filament\Resources\SampleResource\Pages;

use App\Filament\Resources\SampleResource;
use Filament\Resources\Pages\Page;

class Recomendations extends Page
{
    protected static string $resource = SampleResource::class;

    protected static string $view = 'filament.resources.sample-resource.pages.recomendations';
}
