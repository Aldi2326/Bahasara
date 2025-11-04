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
            $table->string('nama_aksara');
            $table->string('status');
            $table->text('deskripsi');
            $table->text('alamat');
            $table->string('dokumentasi');
             $table->string('koordinat');
            $table->foreignId('wilayah_id')->constrained('wilayah')->onDelete('cascade');
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
