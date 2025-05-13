<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Pelanggan extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel eksplisit

    protected $guarded = [];

    public static function getIdPelanggan()
    {
        // query kode perusahaan
        $sql = "SELECT IFNULL(MAX(id_pelanggan), 'AB000') as id_pelanggan
                FROM pelanggan";
        $idpelanggan = DB::select($sql);

        // cacah hasilnya
        foreach ($idpelanggan as $idplg) {
            $id = $idplg->id_pelanggan;
        }

        // Mengambil substring tiga digit akhir dari string PR-000
        $nomor1 = substr($id, -3);
        $nomor2 = $nomor1 + 1; // menambahkan 1, hasilnya adalah integer ex: 1
        $nomakhir = 'PL' . str_pad($nomor2, 3, "0", STR_PAD_LEFT); // menyusun kembali dengan string PR-001
        return $nomakhir;
    }
}