<?php

namespace App\Filament\Resources\SampleResource\RelationManagers;

use Filament\Forms;
use App\Models\Test;
use Filament\Tables;
use App\Models\Sample;
use Livewire\Component;
use App\Models\Template;
use Filament\Forms\Form;
use App\Models\Inventory;
use App\Models\SampleTest;
use Filament\Tables\Table;
use App\Jobs\UpdateInventoryJob;
use Filament\Forms\Components\Section;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Tables\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TestsRelationManager extends RelationManager
{
    protected static string $relationship = 'tests';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)->readOnly(),

                        Forms\Components\Radio::make('status')
                            ->options(Status::class),
                    ])->columns(2),



                TiptapEditor::make('test_result')
                    // ->label('Design')
                    ->profile('')
                    ->tools(['table', 'grid-builder', 'details', 'ordered-list', 'checked-list', 'blockquote', 'media', 'bold', 'heading', 'italic', 'strike', 'underline', 'superscript', 'subscript', 'lead', 'small', 'color', 'highlight', 'align-left', 'align-center', 'align-right', 'hr'])
                    ->output(TiptapOutput::Json)
                    ->disk('public')
                    ->directory('images')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml',])
                    ->visibility('public')
                    ->disableFloatingMenus()
                    ->disableBubbleMenus()
                    // ->disableToolbarMenus()
                    ->required()
                    ->columnSpanFull()
                ,
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                // Tables\Columns\TextColumn::make('status'),

                BadgeColumn::make('status')
                    ->colors([
                        'warning' => static fn($state): bool => $state === 'pending',
                        'success' => static fn($state): bool => $state === 'completed',
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                EditAction::make()->slideOver()
                    ->closeModalByClickingAway(false)
                    ->closeModalByEscaping(false)
                    ->modalAutofocus(false)
                    ->label('test')->icon('heroicon-o-eye-dropper')
                    ->beforeFormFilled(function (EditAction $action, $record) {


                        if (!$record->test_result) {

                            UpdateInventoryJob::dispatch($record->test_id);
                            
                            $sample = Sample::find($record->sample_id);

                            $template = Template::where('test_id', $record->test_id)->where('dosage_form_id', 'like', "%$sample->dosage_form_id%")->first();

                            // if no template is found.
                            if (!$template->content) {
                                SampleTest::where('test_id', $record->test_id)->where('sample_id', $record->sample_id)->update([
                                    'test_result' => '{"type":"doc","content":[{"type":"table","attrs":{"class":null,"style":null},"content":[{"type":"tableRow","attrs":{"class":null,"style":null},"content":[{"type":"tableHeader","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]},{"type":"tableHeader","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]},{"type":"tableHeader","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]}]},{"type":"tableRow","attrs":{"class":null,"style":null},"content":[{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"},"content":[{"type":"text","text":"1."}]}]},{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]},{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]}]},{"type":"tableRow","attrs":{"class":null,"style":null},"content":[{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]},{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]},{"type":"tableCell","attrs":{"class":null,"style":null,"colspan":1,"rowspan":1,"colwidth":null},"content":[{"type":"paragraph","attrs":{"class":null,"style":null,"textAlign":"start"}}]}]}]}]}
'
                                ]);

                                Notification::make()
                                    ->title('No default template')
                                    ->body('No default template has been set up for this test')
                                    ->send();
                                $action->cancel();
                            }

                            SampleTest::where('test_id', $record->test_id)->where('sample_id', $record->sample_id)->update(['test_result' => $template->content, 'inventory_updated' => true]);



                            Notification::make()
                                ->title('Setup completed')
                                ->body('The default template has been set up, you can now continue with the test')
                                ->send();
                            $action->cancel();


                        }


                    })
                // ->hidden(function (RelationManager $livewire) {
                //     return !$livewire->getOwnerRecord()->is_Payment_Made();
                // })
                ,



                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}


enum Status: string implements HasLabel
{
    case Pending = 'pending';
    case Completed = 'completed';
    // case Approved = 'approved';



    public function getLabel(): ?string
    {
        return $this->name;

    }
}