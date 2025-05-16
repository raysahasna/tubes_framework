<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class suplier extends Model
{
    use HasFactory;

    protected $table = 'supliers'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKodeSuplier()
    {
        // Query kode pegawai terakhir
        $sql = "SELECT IFNULL(MAX(id_suplier), 'SUP000') as id_suplier FROM supliers";
        $kodesuplier = DB::select($sql);

        // Pecah hasil query
        foreach ($kodesuplier as $kdsup) {
            $kd = $kdsup->id_suplier;
        }

        // Mengambil tiga digit terakhir dari string (misal PGW000)
        $nowawal = substr($kd, -3);
        $noakhir = $nowawal + 1; // Tambah 1 ke kode terakhir
        $noakhir = 'SUP' . str_pad($noakhir, 3, "0", STR_PAD_LEFT); // Format ulang ke PGW001

        return $noakhir;
    }
}
