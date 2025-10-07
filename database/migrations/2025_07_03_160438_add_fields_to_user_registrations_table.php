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
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->string('company')->nullable();
            $table->decimal('domain_price', 10, 2)->nullable();
            $table->string('domain_name')->nullable();
            $table->integer('year')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropColumn(['company', 'domain_price', 'domain_name', 'year']);
        });
    }
};
