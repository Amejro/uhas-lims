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

        Schema::create('sample_test', function (Blueprint $table) {
            // $table->foreignId('sample_id');
            // $table->foreignId('test_id');
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id')->references('id')->on('samples')->onDelete(null);

            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete(null);

            $table->boolean('inventory_updated')->default(false);
            $table->enum('status', ["pending", "completed", "approved"])->nullable();
            $table->json('test_result')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_test');
    }
};
