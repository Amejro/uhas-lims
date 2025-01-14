<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Template;
use Filament\Forms\Form;
use App\Models\DosageForm;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Builder;
use FilamentTiptapEditor\Enums\TiptapOutput;
use App\Filament\Resources\TemplateResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TemplateResource\RelationManagers;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationGroup = 'Lab Management';

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),


                Forms\Components\Select::make('test_id')
                    ->relationship('test', 'name')
                    ->required(),
                Forms\Components\Select::make('dosage_form_id')
                    ->label('Dosage form')
                    // ->relationship('dosageForm', 'name')
                    ->multiple()
                    ->options(function () {
                        $options = [];
                        $dosages = DosageForm::all();
                        foreach ($dosages as $dosage) {
                            $options[$dosage['id']] = $dosage['name'];
                        }
                        return $options;


                    })
                    ->preload()
                    ->required(),


                TiptapEditor::make('content')
                    ->label('Design')
                    ->profile('')
                    ->tools(['table', 'grid-builder', 'details', 'ordered-list', 'checked-list', 'blockquote', 'media', 'bold', 'heading', 'italic', 'strike', 'underline', 'superscript', 'subscript', 'lead', 'small', 'color', 'highlight', 'align-left', 'align-center', 'align-right', 'hr'])
                    ->disk('public')
                    ->directory('images')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml',])
                    // ->imageCropAspectRatio()



                    ->output(TiptapOutput::Json)
                    ->maxContentWidth('5xl')
                    // ->disableFloatingMenus()
                    // ->disableBubbleMenus()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('test.name')
                    ->numeric(),
                // Tables\Columns\TextColumn::make('dosageForm.name')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Created by')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ReplicateAction::make(),
                Tables\Actions\EditAction::make(),
                ActivityLogTimelineTableAction::make('Activities')->hidden(function () {
                    return !auth()->user()->is_admin();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'view' => Pages\ViewTemplate::route('/{record}'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}


