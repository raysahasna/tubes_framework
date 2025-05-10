<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Produk; //untuk akses kelas model barang

class KeranjangController extends Controller
{
    public function daftarbarang()
    {
        // ambil data barang
        $barang = Produk::all();
        // kirim ke halaman view
        return view('galeri',
                        [ 
                            'barang'=>$barang,
                        ]
                    ); 
    }
}
