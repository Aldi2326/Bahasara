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
        Schema::create('sastra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sastra');
            $table->text('alamat');
            $table->string('jenis');
            $table->text('deskripsi');
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
        Schema::dropIfExists('sastra');
    }
};
