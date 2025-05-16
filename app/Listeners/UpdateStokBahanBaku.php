<?php

namespace App\Listeners;

use App\Events\BahanBakuDibeli;
use App\Models\BahanBaku;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStokBahanBaku implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BahanBakuDibeli $event): void
    {
        $pembelianBahanBaku = $event->pembelianBahanBaku;

        foreach ($pembelianBahanBaku->detailPembelian as $item) {
            $bahanBaku = BahanBaku::find($item['bahan_baku_id']);
            if ($bahanBaku) {
                $bahanBaku->increment('stok', $item['qty']);
            }
        }
    }
}