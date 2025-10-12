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
        Schema::create('actual_shift_pagis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('actual_omset_retail')->nullable();
            $table->bigInteger('actual_tc_retail')->nullable();
            $table->bigInteger('actual_omset_pesanan')->nullable();
            $table->bigInteger('actual_tc_pesanan')->nullable();
            $table->bigInteger('actual_target_lainnya')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actual_shift_pagis');
    }
};
