<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs'; // nama tabel (opsional kalau sesuai konvensi)

    // Kolom-kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'nama_barang',
        'harga',
        'stok',
    ];
}
