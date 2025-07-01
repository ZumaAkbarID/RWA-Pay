<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MerchantResource\Pages;
use App\Filament\Resources\MerchantResource\RelationManagers;
use App\Models\Merchant;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('api_key')->disabled(),
            TextInput::make('api_secret')->disabled(),
            TextInput::make('fee_flat')->numeric()->default(0),
            TextInput::make('fee_percent')->numeric()->default(0)
                ->helperText('Persentase biaya transaksi yang dikenakan, misal 0.7 untuk 0.7%')
                ->maxValue(100)
                ->minValue(0),
            TextInput::make('target_url')
                ->helperText('URL yang akan menerima notifikasi webhook dari RWA-Pay')
                ->required()
                ->url()
                ->maxLength(500),
            Toggle::make('is_active')->default(true),
            Toggle::make('fee_merchant')
                ->label('Beban Fee')
                ->helperText('Tandai jika merchant menanggung biaya transaksi')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('api_key')->copyable()->limit(10),
                TextColumn::make('fee_flat'),
                TextColumn::make('fee_percent'),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                ToggleColumn::make('fee_merchant')
                    ->label('Beban Fee'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }
}