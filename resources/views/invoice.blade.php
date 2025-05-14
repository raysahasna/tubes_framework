<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
        .invoice-container {
            width: 300px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 15px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 15px;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #eee;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h3>Struk Pembelian</h3>
            <p>Tanggal: {{ $transaksi->created_at->format('d-m-Y H:i:s') }}</p>
            <p>No. Transaksi: #{{ $transaksi->id }}</p>
        </div>

        <div class="invoice-details">
            @foreach($detailTransaksi as $item)
            <div class="item-row">
                <span>{{ $item->nama_produk }} ({{ $item->jumlah }} x {{ number_format($item->harga, 0, ',', '.') }})</span>
                <span class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>

        <div class="total-row">
            <span>Total</span>
            <span class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <p>Terima kasih atas pembelian Anda!</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            // Setelah mencetak, Anda bisa kembali ke halaman kasir atau halaman lain
            // window.location.href = "{{ route('depan') }}";
        };
    </script>
</body>
</html>