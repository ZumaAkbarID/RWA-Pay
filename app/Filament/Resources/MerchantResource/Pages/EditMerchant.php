<?php

namespace App\Filament\Resources\MerchantResource\Pages;

use App\Filament\Resources\MerchantResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Ramsey\Uuid\Uuid;

class EditMerchant extends EditRecord
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('regenerateKey')
                ->label('Regenerate API Key & Secret')
                ->color('danger')
                ->icon('heroicon-o-key')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update([
                        'api_key' => Uuid::uuid4()->toString(),
                        'api_secret' => Uuid::uuid7()->toString(),
                    ]);

                    $this->refreshFormData([
                        'api_key',
                        'api_secret',
                    ]);

                    Notification::make()
                        ->title('API Key & Secret Regenerated')
                        ->success()
                        ->send();
                }),
        ];
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}