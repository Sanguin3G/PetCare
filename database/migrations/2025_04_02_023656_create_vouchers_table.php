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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('ma');
            $table->integer('soluong');
            $table->integer('dk_hoadon')->nullable();
            $table->integer('dk_soluong')->nullable();
            $table->integer('discount');
            $table->integer('status');
            $table->text('description')->nullable();
            $table->string('time_start');
            $table->string('time_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
