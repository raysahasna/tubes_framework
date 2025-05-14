<?php

namespace App\Filament\Resources\PembelianBahanBakuResource\Pages;

use App\Events\BahanBakuDibeli;
use App\Filament\Resources\PembelianBahanBakuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePembelianBahanBaku extends CreateRecord
{
    protected static string $resource = PembelianBahanBakuResource::class;

    protected function afterCreate(): void
    {
        event(new BahanBakuDibeli($this->record));
    }
}