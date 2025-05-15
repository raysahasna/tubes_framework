<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Support\Facades\DB;

class PembelianBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_nota',
        'tanggal_transaksi',
        'supplier_id',
        'detailPembelian',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'detailPembelian' => 'array',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public static function generateNoFakturPembelian(): string
    {
        // Query kode faktur pembelian
        $sql = "SELECT IFNULL(MAX(no_nota), 'F-0000000') as no_nota FROM pembelian_bahan_bakus";
        $lastNoNota = DB::select($sql);

        $nomorTerakhir = 'F-0000000';
        foreach ($lastNoNota as $nota) {
            $nomorTerakhir = $nota->no_nota;
        }

        // Ambil bagian angka setelah 'F-'
        $angkaTerakhirStr = substr($nomorTerakhir, 2);
        $angkaTerakhir = intval($angkaTerakhirStr);

        // Tambahkan 1
        $angkaBerikutnya = $angkaTerakhir + 1;

        // Format dengan 'F-' dan leading zeros (panjang 7 digit setelah 'F-')
        $noFakturBaru = 'F-' . str_pad($angkaBerikutnya, 7, '0', STR_PAD_LEFT);

        return $noFakturBaru;
    }
}