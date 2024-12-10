<?php

namespace App\Filament\Resources\PaymentResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentRecord;

use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PaymentRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'paymentRecords';



    public function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('GH₵')
                    // ->hint(function (RelationManager $livewire) {
                    //     return $livewire->getOwnerRecord()->amount_paid == 0 ? "At least GH₵ {$livewire->getOwnerRecord()->balance_due} (60%) required." : "Full payment of  GH₵ {$livewire->getOwnerRecord()->balance_due} required. ";
                    // })
                    ->rules(
                        static function (RelationManager $livewire): Closure {
                            return static function (string $attribute, $value, Closure $fail) use ($livewire) {
                                if ($livewire->getOwnerRecord()->amount_paid == 0 && $value > $livewire->getOwnerRecord()->balance_due) {
                                    $fail("Amount cannot be more than ( GH₵ {$livewire->getOwnerRecord()->balance_due}).");
                                }

                                if ($livewire->getOwnerRecord()->amount_paid > 0 && $value > $livewire->getOwnerRecord()->balance_due) {
                                    $fail("Amount cannot be more than (GH₵ {$livewire->getOwnerRecord()->balance_due}).");
                                }

                                if ($livewire->getOwnerRecord()->amount_paid > 0 && $value < $livewire->getOwnerRecord()->balance_due) {
                                    $fail("An amount of GH₵ {$livewire->getOwnerRecord()->balance_due} is required.");
                                }

                                if ($livewire->getOwnerRecord()->amount_paid == 0 && $value < $livewire->getOwnerRecord()->balance_due * 0.6) {
                                    $fail("At least 60% required.");
                                }

                            };
                        }
                    )
                ,
                TextInput::make('payment_method')
                    ->required(),
                TextInput::make('transaction_id'),
                TextInput::make('note'),
                TextInput::make('payment_id')->default(function (RelationManager $livewire): string {
                    return $livewire->getOwnerRecord()->id;
                })->hidden(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('amount')->label('Amount paid')
                    ->money('GHS')

                ,
                TextColumn::make('payment_method'),
                TextColumn::make('transaction_id'),
                TextColumn::make('user.name')
                    ->label('Received by')
                    ->numeric(),
                TextColumn::make('created_at')
                    ->label('Date received')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->slideOver()
                    ->hidden(function (RelationManager $livewire) {
                        return $livewire->getOwnerRecord()->balance_due == 0;
                    }),
                // Action::make('Receipt')
                //     ->icon('heroicon-o-ticket')
                //     ->url(fn(Payment $payment) => route('receipt.pdf.download', 5))
                //     ->openUrlInNewTab()
                //     ->requiresConfirmation(),


            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
    }
}
