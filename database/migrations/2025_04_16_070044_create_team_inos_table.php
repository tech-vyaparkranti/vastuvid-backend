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
        Schema::create('team_infos', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('designation');
            $table->string('youtube_link');
            $table->string('linkedin_link');
            $table->string('facebook_link');
            $table->integer('position');
            $table->string('twitter_link');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_infos');
    }
};
