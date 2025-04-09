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
        Schema::create('voucher_users', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->integer('soluong');
            $table->integer('status');
            $table->string('id_voucher', 10);
            $table->foreign('id_voucher')->references('id')->on('vouchers')->onDelete('cascade');
            $table->unsignedInteger('id_Cus');
            $table->foreign('id_Cus')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_users');
    }
};
