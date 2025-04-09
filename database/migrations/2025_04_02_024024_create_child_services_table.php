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
        Schema::create('child_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('cost');
            $table->string('type_pet', 20);
            $table->unsignedInteger('id_Service');
            $table->foreign('id_Service')->references('id')->on('services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_services');
    }
};
