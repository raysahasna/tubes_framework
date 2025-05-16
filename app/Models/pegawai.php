<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getKodePegawai()
    {
        // Query kode pegawai terakhir
        $sql = "SELECT IFNULL(MAX(id_pegawai), 'PGW000') as id_pegawai FROM pegawais";
        $kodepegawai = DB::select($sql);

        // Pecah hasil query
        foreach ($kodepegawai as $kdpgw) {
            $kd = $kdpgw->id_pegawai;
        }

        // Mengambil tiga digit terakhir dari string (misal PGW000)
        $nowawal = substr($kd, -3);
        $noakhir = $nowawal + 1; // Tambah 1 ke kode terakhir
        $noakhir = 'PGW' . str_pad($noakhir, 3, "0", STR_PAD_LEFT); // Format ulang ke PGW001

        return $noakhir;
    }
}
