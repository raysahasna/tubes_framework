@extends('layout')

@section('konten')
<style>
    body {
        background-color: rgb(158, 165, 173); /* Warna abu-abu terang sebagai background */
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 10px;
    }

    .row-cols-2, .row-cols-sm-3, .row-cols-md-4, .row-cols-lg-4 {
        grid-gap: 10px;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 10px;
    }

    .product-image {
        max-width: 80px;
        height: auto;
        margin-bottom: 5px;
    }

    .product-title {
        font-size: 0.8em;
        margin-bottom: 3px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .product-price {
        font-size: 0.9em;
        color: #007bff;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .add-to-cart-btn {
        font-size: 0.7em;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .product-card.out-of-stock {
        filter: grayscale(100%);
        opacity: 0.7;
    }

    .product-card.out-of-stock .product-price {
        color: #666 !important;
    }

    .product-card.out-of-stock .add-to-cart-btn {
        background-color: #ccc !important;
        border-color: #ccc !important;
        color: #666 !important;
        cursor: not-allowed !important;
    }

    .transaction-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .item-details {
        flex-grow: 1;
        margin-right: 10px;
        font-size: 0.8em;
    }

    .item-quantity {
        display: flex;
        align-items: center;
    }

    .quantity-btn {
        padding: 2px 5px;
        font-size: 0.7em;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f8f9fa;
        cursor: pointer;
        margin: 0 3px;
    }

    .quantity-input {
        width: 40px;
        text-align: center;
        font-size: 0.8em;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 2px;
        margin: 0 3px;
    }

    .item-subtotal {
        font-size: 0.9em;
        font-weight: bold;
        min-width: 60px;
        text-align: right;
    }

    .transaction-summary {
        margin-top: 15px;
        font-size: 0.9em;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3px;
    }

    .total-row {
        font-size: 1.1em;
        font-weight: bold;
        color: #28a745;
        margin-top: 10px;
        padding-top: 5px;
        border-top: 1px solid #eee;
    }

    .pay-button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        width: 100%;
        font-size: 1em;
        cursor: pointer;
        margin-top: 10px;
    }

    .midtrans-button {
        background-color: #f9a01b;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        width: 100%;
        font-size: 1em;
        cursor: pointer;
        margin-top: 5px;
    }

    .qris-va-button {
        background-color: #6772E5;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        width: 100%;
        font-size: 1em;
        cursor: pointer;
        margin-top: 5px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="row mb-3">
                <div class="col">
                    <form action="{{ route('cari.produk') }}" method="GET">
                        <input type="text" class="form-control form-control-sm" placeholder="Cari..." name="cari">
                    </form>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4">
                @foreach($produk as $p)
                    <div class="col mb-3">
                        <div class="card product-card h-100 shadow-sm {{ $p->stok <= 0 ? 'out-of-stock' : '' }}">
                            <img src="{{ Storage::url($p->foto) }}" alt="{{ $p->nama_produk }}" class="product-image img-fluid">
                            <h6 class="product-title">{{ $p->nama_produk }}</h6>
                            <p class="product-price">Rp {{ number_format($p->harga_produk, 0, ',', '.') }}</p>
                            <form action="{{ route('tambah.keranjang', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-primary add-to-cart-btn w-100" {{ $p->stok <= 0 ? 'disabled' : '' }}>
                                    {{ $p->stok <= 0 ? 'Stok Habis' : '+ Tambah' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="transaction-header">
                        <strong>Petugas</strong>
                        <div>
                            <select class="form-select form-select-sm d-inline w-auto">
                                <option>{{ Auth::user()->name }}</option>
                            </select>
                            <input type="date" class="form-control form-control-sm d-inline w-auto" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    @if(count($keranjang) > 0)
                        @foreach($keranjang as $id => $item)
                            <div class="transaction-item">
                                <div class="item-details">
                                    <div>{{ $item['nama_produk'] }}</div>
                                    <small class="text-muted">Rp {{ number_format($item['harga_produk'], 0, ',', '.') }}</small>
                                </div>
                                <div class="item-quantity">
                                    <form action="{{ route('kurang.keranjang', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="quantity-btn">-</button>
                                    </form>
                                    <input type="text" class="quantity-input" value="{{ $item['jumlah'] }}" readonly>
                                    <form action="{{ route('tambah.keranjang.langsung', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="quantity-btn">
