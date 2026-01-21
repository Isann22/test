<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->string('drive_link', 500)->nullable()->after('additional_info');
        });
    }

    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn('drive_link');
        });
    }
};
