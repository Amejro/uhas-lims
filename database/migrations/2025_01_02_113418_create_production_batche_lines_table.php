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
        Schema::create('production_batche_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(0)->nullable();
            $table->integer('estimate_quantity')->default(0)->nullable();
            // $table->foreignId('product_variant_id')->constrained()->nullOnDelete();
            // $table->foreignId('production_batche_id')->constrained()->nullOnDelete();

            $table->unsignedBigInteger('product_variant_id');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete(null);

            $table->unsignedBigInteger('production_batche_id');
            $table->foreign('production_batche_id')->references('id')->on('production_batches')->onDelete(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_batche_lines');
    }
};
