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
        Schema::create('photographer_applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fullname');
            $table->string('email');
            $table->string('phonenumber');
            $table->json('cameras'); // Array of cameras
            $table->string('instagram_link');
            $table->string('portofolio_link');
            $table->json('moments'); // Array of moments
            $table->json('cities'); // Array of cities
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographer_applicants');
    }
};
