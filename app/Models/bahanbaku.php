<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class bahanbaku extends Model
{
    use HasFactory;

    protected $table = 'bahanbakus'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKodebahanbaku()
    {
        // Query kode pegawai terakhir
        $sql = "SELECT IFNULL(MAX(id_bahan_baku), 'BHN000') as id_bahan_baku FROM bahanbakus";
        $kodebahanbaku = DB::select($sql);

        // Pecah hasil query
        foreach ($kodebahanbaku as $kdbhn) {
            $kd = $kdbhn->id_bahan_baku;
        }

        // Mengambil tiga digit terakhir dari string (misal PGW000)
        $nowawal = substr($kd, -3);
        $noakhir = $nowawal + 1; // Tambah 1 ke kode terakhir
        $noakhir = 'BHN' . str_pad($noakhir, 3, "0", STR_PAD_LEFT); // Format ulang ke PGW001

        return $noakhir;
    }
}
