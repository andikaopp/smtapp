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
        Schema::create('target_shift_siangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('omset_retail')->nullable();
            $table->bigInteger('tc_retail')->nullable();
            $table->bigInteger('omset_pesanan')->nullable();
            $table->bigInteger('tc_pesanan')->nullable();
            $table->bigInteger('target_lainnya')->nullable();
            $table->bigInteger('jumlah_target')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_shift_siangs');
    }
};
