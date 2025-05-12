<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'status',
        'order_id', // Tambahkan kolom order_id
        'snap_token', // Tambahkan kolom snap_token
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

      public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}