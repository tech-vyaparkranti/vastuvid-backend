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
        Schema::table('package_orders', function (Blueprint $table) {
            
            $table->string('cashfree_order_id')->nullable()->after('payment_status');
            $table->string('payment_session_id')->nullable()->after('cashfree_order_id');
            $table->timestamp('payment_completed_at')->nullable()->after('transaction_id');

            // Add columns for base and GST amounts, useful for financial reporting
            $table->decimal('base_amount', 10, 2)->nullable()->after('amount'); // Stores original amount before GST
            $table->decimal('gst_amount', 10, 2)->nullable()->after('base_amount');   // Stores the calculated GST amount
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table) {
            // Drop the columns in reverse order of creation, or as a group.
            $table->dropColumn([
                'cashfree_order_id',
                'payment_session_id',
                'payment_completed_at',
                'base_amount',
                'gst_amount',
            ]);
        });
    }
};
