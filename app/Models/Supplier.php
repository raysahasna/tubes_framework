<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // Pastikan 'id' ada di sini
        'nama_supplier',
        'alamat',
        'no_telp',
        'email',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = self::generateIdSupplier();
        });
    }

    public static function generateIdSupplier(): string
    {
        $prefix = 'SP-';
        $length = 7;
        $sql = "SELECT IFNULL(MAX(id), '" . $prefix . str_repeat('0', $length) . "') as id FROM suppliers WHERE id LIKE '" . $prefix . "%'";
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