<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // Pastikan 'id' ada di sini
        'nama',
        'harga',
        'satuan',
        'stok',
    ];

    public $incrementing = false; // Menonaktifkan auto-increment default
    protected $keyType = 'string'; // Tipe data primary key adalah string

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateIdBahanBaku();
        });
    }

    public static function generateIdBahanBaku(): string
    {
        $prefix = 'BB-';
        $length = 7;
        $sql = "SELECT IFNULL(MAX(id), '" . $prefix . str_repeat('0', $length) . "') as id FROM bahan_bakus WHERE id LIKE '" . $prefix . "%'";
        $lastId = DB::select($sql);

        $nomorTerakhir = $prefix . str_repeat('0', $length);
        foreach ($lastId as $item) {
            $nomorTerakhir = $item->id;
        }

        $angkaTerakhirStr = substr($nomorTerakhir, strlen($prefix));
        $angkaTerakhir = intval($angkaTerakhirStr);
        $angkaBerikutnya = $angkaTerakhir + 1;

        $idBaru = $prefix . str_pad($angkaBerikutnya, $length, '0', STR_PAD_LEFT);

        return $idBaru;
    }
}