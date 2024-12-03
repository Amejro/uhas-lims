<?php

namespace App\Filament\Resources\SampleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sample;
use App\Models\Template;
use Filament\Forms\Form;
use App\Models\SampleTest;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class TestsRelationManager extends RelationManager
{
    protected static string $relationship = 'tests';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)->readOnly(),

                TiptapEditor::make('test_result')
                    // ->label('Design')
                    ->profile('')
                    ->tools(['table', 'grid-builder', 'details', 'ordered-list', 'checked-list', 'blockquote', 'bold', 'heading', 'italic', 'strike', 'underline', 'superscript', 'subscript', 'lead', 'small', 'color', 'highlight', 'align-left', 'align-center', 'align-right', 'hr'])
                    ->output(TiptapOutput::Json)
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
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver()

                    ->closeModalByClickingAway(false)
                    ->closeModalByEscaping(false)
                    ->modalAutofocus(false)
                    ->beforeFormFilled(function ($record) {
                        if (!$record->test_result) {

                            $sample = Sample::find($record->sample_id);

                            $template = Template::where('test_id', $record->test_id)->where('dosage_form_id', $sample->dosage_form_id)->first();

                            SampleTest::where('test_id', $record->test_id)->where('sample_id', $record->sample_id)->update(['test_result' => $template->content]);

                        }


                    })

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
