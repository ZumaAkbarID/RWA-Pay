<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Jobs\SendWebhookJob;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendManual')
                ->label('Kirim Webhook Manual')
                ->icon('heroicon-o-paper-airplane')
                // ->visible(fn() => $this->record->is_manual)
                ->requiresConfirmation()
                ->color('primary')
                ->action(function () {
                    SendWebhookJob::dispatch($this->record);
                    Notification::make()
                        ->title('Webhook Manual Dikirim')
                        ->body('Webhook untuk transaksi ini telah berhasil dikirim secara manual.')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function afterActionCalled(): void
    {
        Notification::make()
            ->title('Transaksi Diperbarui')
            ->body('Transaksi telah berhasil diperbarui.')
            ->success()
            ->send();

        $this->record->refresh();
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }
}