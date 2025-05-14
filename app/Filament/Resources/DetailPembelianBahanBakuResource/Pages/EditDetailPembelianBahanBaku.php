<?php

namespace App\Filament\Resources\DetailPembelianBahanBakuResource\Pages;

use App\Filament\Resources\DetailPembelianBahanBakuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailPembelianBahanBaku extends EditRecord
{
    protected static string $resource = DetailPembelianBahanBakuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
