<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_transaksis', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->foreignId('transaksi_id')->constrained('transaksis')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_transaksis');
    }
}
