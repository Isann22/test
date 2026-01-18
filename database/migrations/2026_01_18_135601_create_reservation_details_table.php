<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('reservation_id')->unique();
            $table->uuid('city_id');
            $table->uuid('moment_id');
            $table->uuid('package_id');
            $table->date('photoshoot_date');
            $table->time('photoshoot_time');
            $table->unsignedTinyInteger('pax')->default(1);
            $table->string('location_type', 50);
            $table->text('location_details')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('moment_id')->references('id')->on('moments')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');

            $table->index(['photoshoot_date', 'city_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_details');
    }
};
