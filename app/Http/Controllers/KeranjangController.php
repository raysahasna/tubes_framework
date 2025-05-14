<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Session;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Transaksi; // Pastikan model Transaksi Anda ada
use App\Models\DetailTransaksi; // Jika Anda punya model DetailTransaksi
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KeranjangController extends Controller
{
    public function daftarbarang()
    {
        $produk = Produk::all();
        $keranjang = session()->get('keranjang', []);

        $subtotal = 0;
        foreach ($keranjang as $item) {
            if (isset($item['harga_produk']) && isset($item['jumlah'])) {
                $subtotal += $item['harga_produk'] * $item['jumlah'];
            }
        }

        $diskon = 5;
        $pajak = 11;
        $total = round($subtotal * (1 - ($diskon / 100)) * (1 + ($pajak / 100)));

        return view('kasir', [
            'produk' => $produk,
            'keranjang' => $keranjang,
            'subtotal' => $subtotal,
            'diskon' => $diskon,
            'pajak' => $pajak,
            'total' => $total,
        ]);
    }

    public function tambahKeKeranjang(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['harga_produk'] * $keranjang[$id]['jumlah'];
        } else {
            $keranjang[$id] = [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'jumlah' => 1,
                'subtotal' => $produk->harga_produk,
            ];
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('depan')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function tambahKeKeranjangLangsung(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['harga_produk'] * $keranjang[$id]['jumlah'];
        } else {
            $keranjang[$id] = [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'jumlah' => 1,
                'subtotal' => $produk->harga_produk,
            ];
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('depan')->with('success', 'Jumlah produk di keranjang berhasil ditambahkan!');
    }

    public function kurangiDariKeranjang(Request $request, $id)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']--;

            if ($keranjang[$id]['jumlah'] < 1) {
                unset($keranjang[$id]);
            } else {
                $produk = Produk::findOrFail($id);
                $keranjang[$id]['subtotal'] = $keranjang[$id]['harga_produk'] * $keranjang[$id]['jumlah'];
            }
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('depan')->with('info', 'Jumlah produk berhasil dikurangi!');
    }

    public function hapusDariKeranjang(Request $request, $id)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('depan')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clearSession()
    {
        session()->flush();
        return redirect()->route('depan')->with('success', 'Session berhasil dikosongkan!');
    }

    public function prosesPembayaranKasir(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        $totalBayar = 0;
        $detailTransaksiData = []; // Ubah nama variabel agar tidak sama dengan model

        \DB::beginTransaction(); // Mulai transaksi database untuk memastikan atomisitas

        try {
            foreach ($keranjang as $id => $item) {
                $produk = Produk::findOrFail($id);

                // Periksa apakah stok mencukupi
                if ($produk->stok < $item['jumlah']) {
                    \DB::rollBack(); // Batalkan transaksi jika stok tidak cukup
                    return redirect()->back()->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
                }

                // Kurangi stok produk
                $produk->stok -= $item['jumlah'];
                $produk->save();

                $totalBayar += $item['harga_produk'] * $item['jumlah'];

                // Simpan detail transaksi untuk database
                $detailTransaksiData[] = [
                    'produk_id' => $id,
                    'nama_produk' => $item['nama_produk'],
                    'harga' => $item['harga_produk'], // Gunakan 'harga' sesuai dengan kolom DetailTransaksi
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ];
            }

            $diskon = 5;
            $pajak = 11;
            $total = round($totalBayar * (1 - ($diskon / 100)) * (1 + ($pajak / 100)));

            // Simpan data transaksi ke database
            $transaksi = new Transaksi();
            $transaksi->user_id = auth()->user()->id;
            $transaksi->total_harga = $total;
            $transaksi->metode_pembayaran = 'tunai';
            $transaksi->status = 'dibayar';
            $transaksi->save();

            // Simpan detail transaksi ke tabel detail_transaksi
            foreach ($detailTransaksiData as $detail) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $detail['produk_id'],
                    'nama_produk' => $detail['nama_produk'],
                    'harga' => $detail['harga'], // Gunakan 'harga'
                    'jumlah' => $detail['jumlah'],
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            \DB::commit(); // Commit transaksi jika semua berhasil
            Session::forget('keranjang');

            // Redirect ke halaman invoice
            return redirect()->route('invoice.show', $transaksi->id)->with('success', 'Pembayaran berhasil! Invoice Anda telah dibuat.');

        } catch (\Exception $e) {
            \DB::rollBack(); // Batalkan transaksi jika terjadi error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function prosesPembayaranMidtrans(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        $subtotal = 0;
        $item_details = [];

        if (empty($keranjang)) {
            return redirect()->route('depan')->with('warning', 'Keranjang belanja Anda kosong.');
        }

        foreach ($keranjang as $id => $item) {
            $subtotal += $item['harga_produk'] * $item['jumlah'];
            $item_details[] = [
                'id' => $item['id'],
                'price' => $item['harga_produk'],
                'quantity' => $item['jumlah'],
                'name' => $item['nama_produk'],
            ];
        }

        $diskon = 5;
        $pajak = 11;
        $total = round($subtotal * (1 - ($diskon / 100)) * (1 + ($pajak / 100)));
        $order_id = 'TRANSACTION-' . time() . '-' . auth()->id();

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false); // Tambahkan ini jika belum ada
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);   // Tambahkan ini jika belum ada
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);    

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $total,
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'payment_methods' => ['qris', 'bca'], // Aktifkan QRIS dan VA BCA (atau metode lain yang Anda inginkan)
            'bca' => [ // Opsi tambahan untuk BCA VA (opsional)
                'bill_info1' => 'Pembayaran Order',
                'bill_info2' => $order_id,
            ],
        ];

        Log::info('Parameter Midtrans:', $params);

        try {
            $snapToken = Snap::getSnapToken($params);
            Log::info('Snap Token:', ['token' => $snapToken]);

            $transaksi = new Transaksi();
            $transaksi->user_id = auth()->id();
            $transaksi->order_id = $order_id;
            $transaksi->total_harga = $total;
            $transaksi->metode_pembayaran = 'midtrans';
            $transaksi->status = 'pending';
            $transaksi->snap_token = $snapToken;
            $transaksi->save();

            foreach ($keranjang as $id => $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['id'],
                    'nama_produk' => $item['nama_produk'],
                    'harga' => $item['harga_produk'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

            }

            return view('midtrans_checkout', ['snapToken' => $snapToken, 'orderId' => $order_id]);
        } catch (\Exception $e) {
            Log::error('Gagal membuat transaksi Midtrans: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran dengan Midtrans: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transaction = Transaksi::where('order_id', $request->order_id)->first();

            if ($transaction) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $transaction->status = 'dibayar';
                    $transaction->save();
                    Session::forget('keranjang'); // Kosongkan keranjang setelah pembayaran berhasil

                    // Redirect ke halaman invoice
                    return redirect()->route('invoice.show', $transaction->id)->with('success', 'Pembayaran Midtrans berhasil! Invoice Anda telah dibuat.');

                } elseif ($request->transaction_status == 'pending') {
                    $transaction->status = 'pending';
                    $transaction->save();
                } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'expire' || $request->transaction_status == 'cancel') {
                    $transaction->status = 'gagal';
                    $transaction->save();
                }
                return response('OK', 200);
            }
        } else {
            return response('Forbidden', 403);
        }
        
    }

    public function showInvoice(Transaksi $transaksi)
    {
        $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->get();

        return view('invoice', [
            'transaksi' => $transaksi,
            'detailTransaksi' => $detailTransaksi,
        ]);
    }

    public function riwayatTransaksi()
{
    $riwayat = Transaksi::orderBy('created_at', 'desc')->paginate(10); // Ambil riwayat transaksi, urutkan berdasarkan tanggal terbaru, dan paginasi

    return view('riwayat_transaksi', compact('riwayat'));
}

public function tampilkanInvoice(Transaksi $transaksi)
{
    $detailTransaksi = DetailTransaksi::where('transaksi_id', $transaksi->id)->get();

    return view('invoice', [
        'transaksi' => $transaksi,
        'detailTransaksi' => $detailTransaksi,
    ]);
}
}