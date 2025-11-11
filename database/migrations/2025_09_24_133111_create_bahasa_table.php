<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bahasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->foreignId(column: 'nama_bahasa_id')->nullable()->constrained('nama_bahasa')->onDelete('cascade');
            $table->text('alamat');
            $table->string('status');
            $table->integer('jumlah_penutur');
            $table->text('deskripsi');
            $table->string('dokumentasi');
            $table->string('koordinat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahasa');
    }
};
