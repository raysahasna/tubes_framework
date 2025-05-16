<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs'; // Sesuaikan nama tabel di database jika berbeda
    protected $fillable = [
        'user_id', 
        'produk_id', 
        'jumlah', 
        'status'
    ]; // Sesuaikan kolom yang ada di tabel keranjangs

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

}

