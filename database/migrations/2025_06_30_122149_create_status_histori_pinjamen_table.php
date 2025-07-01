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
        Schema::create('status_histori_pinjaman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('jumlah_pinjaman', 11, 2);
            $table->enum('status', ['diproses', 'disetujui', 'dicairkan', 'lunas', 'dibatalkan']);
            $table->text('catatan')->nullable();
            $table->foreignUuid('pinjaman_id')->nullable()->constrained('pinjaman', 'id')->onDelete('cascade');
            $table->foreignUuid('grup_id')->nullable()->constrained('grup', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histori_pinjamen');
    }
};
