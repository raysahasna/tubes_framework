<?php

namespace App\Filament\Resources\DetailPembelianBahanBakuResource\Pages;

use App\Filament\Resources\DetailPembelianBahanBakuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailPembelianBahanBakus extends ListRecords
{
    protected static string $resource = DetailPembelianBahanBakuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
