@extends('layout')

@section('konten')
<div class="container py-4">
    <h2>Riwayat Transaksi</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayat as $transaksi)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>#{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                    <td>{{ ucfirst($transaksi->status) }}</td>
                    <td>
                        <a href="{{ route('riwayat.invoice', $transaksi->id) }}" class="btn btn-sm btn-info">Lihat Invoice</a>
                        </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Tidak ada riwayat transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $riwayat->links() }} </div>
@endsection