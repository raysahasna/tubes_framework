@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Tambah Penjualan</h1>
    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="no_faktur" class="block text-gray-700">No Faktur</label>
            <input type="text" name="no_faktur" id="no_faktur" class="w-full border-gray-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="w-full border-gray-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label for="pembeli" class="block text-gray-700">Pembeli</label>
            <input type="text" name="pembeli" id="pembeli" class="w-full border-gray-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label for="total" class="block text-gray-700">Total</label>
            <input type="number" name="total" id="total" class="w-full border-gray-300 rounded-lg">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Simpan
        </button>
    </form>
</div>
@endsection