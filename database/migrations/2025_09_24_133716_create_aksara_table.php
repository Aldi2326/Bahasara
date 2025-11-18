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
        Schema::create('aksara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
            $table->foreignId('nama_aksara_id')->nullable()->constrained('nama_aksara')->onDelete('cascade');
            $table->text('alamat');
            $table->string('status');
            $table->text('deskripsi');
            $table->string('dokumentasi');
            $table->string('koordinat');
            $table->string('lokasi');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aksara');
    }
};
