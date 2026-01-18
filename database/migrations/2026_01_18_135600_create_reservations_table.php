<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('reservation_code', 20)->unique();
            $table->string('status', 20)->default('pending');
            $table->decimal('package_price', 15, 2);
            $table->decimal('tax_rate', 5, 4)->default(0.1200);
            $table->decimal('tax_amount', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
