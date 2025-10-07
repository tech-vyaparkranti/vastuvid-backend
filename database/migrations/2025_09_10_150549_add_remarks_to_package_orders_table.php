<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('package_orders', function (Blueprint $table) {
        $table->text('remarks')->nullable()->after('gst_amount'); // ✅ Add remarks field
    });
}

public function down()
{
    Schema::table('package_orders', function (Blueprint $table) {
        $table->dropColumn('remarks');
    });
}

};
