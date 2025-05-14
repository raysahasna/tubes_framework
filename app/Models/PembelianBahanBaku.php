<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'tanggal', 'total'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPembelianBahanBaku::class);
    }
}
