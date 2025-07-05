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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('nominal_pinjaman', 11, 2);
            $table->foreignUuid('tenor')->nullable()->constrained('tenor', 'id')->onDelete('set null');
            $table->decimal('jumlah_pinjaman', 11, 2);
            $table->dateTime('jadwal_pencairan')->nullable();
            $table->boolean('dana_kembali')->default(false);
            $table->decimal('suku_bunga', 5, 2);
            $table->foreignUuid('status_id')->nullable()->constrained('status', 'id')->onDelete('set null');
            $table->foreignUuid('grup_id')->nullable()->constrained('grup', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
