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
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 1024);
            $table->timestamps();
            $table->unsignedInteger('idCus');
            $table->foreign('idCus')->references('id')->on('users')->onDelete('cascade');
            $table->string('idPro', 10);
            $table->foreign('idPro')->references('idPro')->on('products')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
