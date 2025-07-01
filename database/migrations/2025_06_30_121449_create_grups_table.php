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
        Schema::create('grup', function (Blueprint $table) {
            $table->uuid('id_grup')->primary();
            $table->string('nama_grup');
            $table->decimal('limit_pinjaman', 11, 2)->default(2000000.00);
            $table->enum('status', ['aktif', 'non-aktif'])->default('non-aktif');
            $table->foreignUuid('ketua_user_id')->nullable()->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grup');
    }
};
