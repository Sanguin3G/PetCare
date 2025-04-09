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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->integer('status')->default(0);
            $table->string('address');
            $table->string('note')->nullable();
            $table->string('thanhtoan');
            $table->timestamps();
            $table->unsignedInteger('idCus');
            $table->foreign('idCus')->references('id')->on('users')->onDelete('cascade');
            $table->string('idVoucher', 10)->nullable();
            $table->foreign('idVoucher')->references('id')->on('vouchers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
