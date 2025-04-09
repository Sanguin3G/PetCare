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
        Schema::create('products', function (Blueprint $table) {
            $table->string('idPro', 10)->primary();
            $table->string('namePro', 255);
            $table->text('description')->nullable();
            $table->integer('count');
            // $table->string('image');
            $table->integer('hot')->nullable();
            $table->integer('cost');
            $table->integer('discount')->nullable();
            $table->timestamps();
            //foreign key categories
            $table->unsignedInteger('idCat');
            $table->foreign('idCat')->references('idCat')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
