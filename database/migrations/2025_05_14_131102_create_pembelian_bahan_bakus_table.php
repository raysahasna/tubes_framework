<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelian_bahan_bakus', function (Blueprint $table) {
            $table->id(); // ID integer auto-incrementing
            $table->string('no_nota');
            $table->date('tanggal_transaksi');
            $table->string('supplier_id'); // Foreign key bertipe string, mereferensikan suppliers.id
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->json('detailPembelian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahan_bakus');
    }
};