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
        Schema::disableForeignKeyConstraints();

        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('content');
            $table->foreignId('test_id')->constrained()->nullOnDelete();
            $table->foreignId('dosage_form_id');
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
