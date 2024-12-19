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

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->string('serial_code')->unique();
            $table->decimal('balance_due', 10, 2);
            $table->enum('status', ["pending", "part payment", "paid"])->default("pending");
            $table->foreignId('sample_id')->constrained('Samples')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('payment_records', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('note')->nullable();
            $table->foreignId('payment_id')->constrained('Payments')->nullOnDelete();
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
        Schema::dropIfExists('payment_records');
        Schema::dropIfExists('payments');

    }
};
