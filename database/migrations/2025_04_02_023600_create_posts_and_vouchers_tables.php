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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->unsignedInteger('discount')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->timestamp('time_start')->nullable();
            $table->timestamp('time_end')->nullable();
        });

        Schema::create('voucher_users', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('id_voucher', 10);
            $table->unsignedInteger('id_user')->nullable();
            $table->unsignedInteger('soluong')->default(0);
            $table->foreign('id_voucher')->references('id')->on('vouchers')->cascadeOnDelete();
            $table->foreign('id_user')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_users');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('posts');
    }
};
