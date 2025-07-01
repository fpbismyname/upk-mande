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
            $table->decimal('jumlah_pinjaman', 11, 2);
            $table->string('tenor');
            $table->decimal('suku_bunga', 3, 2);
            $table->enum('status', ['disetujui', 'ditolak']);
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
