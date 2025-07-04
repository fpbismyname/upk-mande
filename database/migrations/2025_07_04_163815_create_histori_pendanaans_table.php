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
        Schema::create('histori_pendanaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('catatan');
            $table->foreignUuid('grup_id')->nullable()->constrained('grup', 'id');
            $table->foreignUuid('status_id')->nullable()->constrained('status', 'id');
            $table->foreignUuid('pinjaman_id')->nullable()->constrained('pinjaman', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_pendanaan');
    }
};
