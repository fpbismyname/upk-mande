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
        Schema::create('pencairan_dana', function (Blueprint $table) {
            $table->uuid('id_pencairan')->primary();
            $table->dateTime('tanggal_pencairan');
            $table->decimal('jumlah_pencairan', 11, 2);
            $table->text('keterangan');
            $table->foreignUuid('pinjaman_id')->nullable()->constrained('pinjaman', 'id_pinjaman')->onDelete('cascade');
            $table->foreignUuid('grup_id')->nullable()->constrained('grup', 'id_grup')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
