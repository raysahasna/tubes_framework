<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coas extends Model
{
    use HasFactory;

    protected $table = 'coas'; // Sesuaikan dengan nama tabel di database

    protected $fillable = ['header_akun', 'kode_akun', 'nama_akun']; // Pastikan field ini ada di database
}
