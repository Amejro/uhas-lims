<?php

namespace App\Filament\Resources\SampleResource\Pages;


use Filament\Actions;
use App\Models\Sample;
use Filament\Pages\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\Alignment;
use Filament\Pages\Actions\ActionGroup;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SampleResource;


class EditSample extends EditRecord
{
    protected static string $resource = SampleResource::class;



    protected function getHeaderActions(): array
    {
        return [

            Action::make('recommendations')
                ->icon('heroicon-o-hand-thumb-up')

                ->url(fn(Sample $sample) => route('recommendations', $sample))
                ->openUrlInNewTab()

                // ->action(function (Action $action, Sample $sample): void {

                //     // dd($action);
                //   $action->url(fn(Sample $sample) => route('recommendations', $sample))->openUrlInNewTab()
                //         ->icon('heroicon-o-hand-thumb-up');
                //     // route('recommendations', $sample);
                //     // url(fn(Sample $sample) => route('recommendations', $sample))
                //     // ->openUrlInNewTab();
                // })
                ->modalHeading('Report')
                ->modalContent(function (Sample $sample) {
                    // dd($sample);
                    return view(
                        'recommendations',
                        ['record' => $sample],
                    );
                })

                ->modalSubmitAction(false)
                ->modalCancelAction(false)

            ,
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getContentTabLabel(): string|null
    {
        return 'Product Details';
    }
}


