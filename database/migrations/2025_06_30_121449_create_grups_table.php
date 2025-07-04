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
            $table->uuid('id')->primary();
            $table->string('nama_grup');
            $table->decimal('limit_pinjaman', 11, 2)->default(2000000.00);
            $table->foreignUuid('status_id')->nullable()->constrained('status', 'id')->onDelete('set null');
            $table->foreignUuid('ketua_user_id')->nullable()->constrained('users', 'id')->onDelete('cascade');
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
