<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->unsignedTinyInteger('discount_snapshot')->nullable();
        });
    }
    public function down(): void {
        Schema::table('order_detail', fn (Blueprint $table) => $table->dropColumn('discount_snapshot'));
    }
};
