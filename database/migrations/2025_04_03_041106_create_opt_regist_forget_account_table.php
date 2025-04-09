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
        Schema::create('opt_regist_forget_account', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->Integer('OTP');
            $table->string('type', 20);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('expired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opt_regist_forget_account');
    }
};
