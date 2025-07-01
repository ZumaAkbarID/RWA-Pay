<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    Select::make('merchant_id')
                        ->relationship('merchant', 'name')
                        ->required(),

                    TextInput::make('reference')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    TextInput::make('customer_reference'),

                    TextInput::make('amount')->numeric()->required(),
                    TextInput::make('fee')->numeric(),

                    Toggle::make('is_manual')->default(true),
                    TextInput::make('name'),
                    TextInput::make('email'),
                    TextInput::make('phone'),

                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'success' => 'Success',
                            'failed' => 'Failed',
                        ])
                        ->default('pending'),

                    TextInput::make('response_status')->numeric(),
                    TextInput::make('retries')->numeric()->default(0),
                    DateTimePicker::make('last_attempt_at'),
                ]),

                Textarea::make('payload')
                    ->afterStateHydrated(fn(TextArea $component, $state) => $component->state(json_encode($state)))
                    ->rows(5),
                Textarea::make('headers')
                    ->afterStateHydrated(fn(TextArea $component, $state) => $component->state(json_encode($state)))
                    ->rows(5),
                Textarea::make('response_body')->rows(3),
                TextArea::make('qris_static')
                    ->label('QRIS String')
                    ->visibleOn('edit')
                    ->helperText('QRIS string is generated automatically when the transaction is created.')
                    ->columnSpanFull()
                    ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')->searchable()->limit(20),
                TextColumn::make('merchant.name')->label('Merchant')->sortable(),
                TextColumn::make('amount')->money('IDR'),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_manual')->label('Manual Only')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}