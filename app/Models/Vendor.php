<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat', 'telepon'];

    public function pembelianBahanBakus()
    {
        return $this->hasMany(PembelianBahanBaku::class);
    }
}
