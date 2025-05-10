<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel eksplisit
    protected $guarded = []; // Gunakan guarded jika semua kolom boleh diisi (hati-hati)

    /**
     * Ambil kode produk berikutnya secara otomatis.
     */
    public static function getKodeProduk()
    {
        // Query untuk mendapatkan kode produk terakhir
        $sql = "SELECT IFNULL(MAX(kode_produk), 'AB000') as kode_produk FROM produk";
        $kodeproduk = DB::select($sql);

        // Tentukan kode default jika belum ada data di tabel
        $kd = 'AB000';
        foreach ($kodeproduk as $kdprdk) {
            $kd = $kdprdk->kode_produk;
        }

        // Ambil tiga digit terakhir, tambahkan 1, lalu format ulang
        $noawal = (int) substr($kd, -3); // Substring 3 digit terakhir
        $noakhir = $noawal + 1;
        $kodebaru = 'AB' . str_pad($noakhir, 3, "0", STR_PAD_LEFT); // Format hasil

        return $kodebaru;
    }

    /**
     * Mutator untuk menghapus koma dari harga_produk sebelum disimpan.
     */
    public function setHargaProdukAttribute($value)
    {
        $this->attributes['harga_produk'] = str_replace(',', '', $value); // Hapus koma
    }
}
