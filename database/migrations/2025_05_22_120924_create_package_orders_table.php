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
        Schema::create('package_orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('email');
            $table->string('phone');
            $table->decimal('amount', 10, 2);
            $table->string("package_type");
            $table->string("package_class");
            $table->string('payment_status')->default('pending')->nullable();
            $table->string("transaction_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_orders');
    }
};
