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
        Schema::create('cicilan_pinjaman', function (Blueprint $table) {
            $table->uuid('id_cicilan')->primary();
            $table->decimal('jumlah_cicilan', 11, 2);
            $table->dateTime('jatuh_tempo');
            $table->enum('status', ['dibayar', 'belum dibayar']);
            $table->foreignUuid('grup_id')->nullable()->constrained('grup', 'id_grup')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan_pinjaman');
    }
};
