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
        Schema::table('our_services', function (Blueprint $table) {
           if (!Schema::hasColumn('our_services', 'slug')) {
                $table->string('slug')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('our_services', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
