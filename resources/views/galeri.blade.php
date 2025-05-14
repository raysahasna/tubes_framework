@extends('layout')

@section('konten')
<style>
    .container-fluid {
        padding: 20px;
        background-color: #f8f9fa;
        min-height: 100vh; /* Agar background menutupi seluruh tinggi viewport */
    }

    .row {
        display: flex;
        gap: 20px;
    }

    .col-md-8 {
        flex: 0.65; /* Sesuaikan proporsi lebar daftar produk */
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .col-md-4 {
        flex: 0.35; /* Sesuaikan proporsi lebar keranjang & pembayaran */
    }

    .row-cols-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    @media (min-width: 576px) {
        .row-cols-sm-3 {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 768px) {
        .row-cols-md-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (min-width: 992px) {
        .row-cols-lg-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-img-top {
        width: 100%;
        height: auto;
        object-fit: cover; /* Agar gambar tidak terdistorsi */
        max-height: 150px; /* Batasi tinggi gambar */
    }

    .card-body {
        padding: 10px;
        text-align: center;
        flex-grow: 1; /* Agar body card mengisi sisa ruang */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Distribusikan ruang antara elemen */
    }

    .card-title {
        font-size: 0.9em;
        margin-bottom: 5px;
    }

    .btn-outline-primary {
        font-size: 0.8em;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .card-header {
        background-color: #f8f9fa;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        border-radius: 6px 6px 0 0;
    }

    .card-body.p-3 {
        padding: 10px !important;
    }

    .d-flex.justify-content-between.align-items-center.mb-2 {
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .d-flex.justify-content-between.align-items-center.mb-2:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .input-group.input-group-sm {
        width: 120px !important; /* Sesuaikan lebar input group */
    }

    .input-group-sm > .form-control,
    .input-group-sm > .input-group-text,
    .input-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8em;
        border-radius: 4px;
    }

    .fw-bold.ms-2 {
        min-width: 60px; /* Agar total item tidak terlalu sempit */
        text-align: right;
    }

    .card-footer {
        background-color: #f8f9fa;
        padding: 0;
        border-top: 1px solid #ddd;
        border-radius: 0 0 6px 6px;
    }

    .btn-success.btn-lg.w-100 {
        border-radius: 0 0 6px 6px;
        font-size: 1em;
        padding: 12px;
    }

    .form-select.form-select-sm {
        font-size: 0.8em;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        max-width: 150px;
    }

    .form-control.form-control-sm.d-inline {
        font-size: 0.8em;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        max-width: 120px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Cari...">
                </div>
            </div>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4">
                @foreach($produk as $p)
                <div class="col mb-4">
                    <div class="card h-100 shadow-sm text-center">
                        <img src="{{ Storage::url($p->foto) }}" class="card-img-top img-fluid" alt="{{ $p->nama_barang }}">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1">{{ $p->nama_barang }}</h6>
                            <div class="text-primary fw-bold">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                            <button class="btn btn-sm btn-outline-primary mt-2 w-100 add-to-cart" data-id="{{ $p->id }}">+ Tambah</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between">
                        <strong>Umum</strong>
                        <div>
                            <select class="form-select form-select-sm d-inline w-auto">
                                <option>{{ Auth::user()->name }}</option>
                            </select>
                            <input type="date" class="form-control form-control-sm d-inline w-auto" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    @foreach($keranjang as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div>{{ $item->nama_barang }}</div>
                            <small class="text-muted">Rp {{ number_format($item->harga, 0, ',', '.') }}</small>
                        </div>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                            <input type="text" class="form-control text-center" value="{{ $item->jumlah }}">
                            <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                        </div>
                        <div class="fw-bold ms-2">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>Sub Total</div>
                        <div>Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Diskon</div>
                        <div>{{ $diskon }}%</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Penyelesaian</div>
                        <div>0</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>Pajak</div>
                        <div>{{ $pajak }}%</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold text-primary fs-5">
                        <div>Total</div>
                        <div>Rp {{ number_format($total, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <button class="btn btn-success btn-lg w-100 rounded-0">
                        Bayar Rp {{ number_format($total, 0, ',', '.') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection