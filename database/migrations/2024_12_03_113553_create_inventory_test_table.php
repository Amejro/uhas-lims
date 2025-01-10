<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('inventory_test', function (Blueprint $table) {
            // $table->foreignId('inventory_id');
            // $table->foreignId('test_id');

            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');

            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_test');
    }
};
