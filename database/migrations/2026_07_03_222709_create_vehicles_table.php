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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('operator_id')
                ->constrained('operators')
                ->cascadeOnDelete();

            $table->foreignId('transport_mode_id')
                ->constrained('transport_modes')
                ->cascadeOnDelete();

            $table->string('vehicle_code', 50)->unique();
            $table->string('plate_number', 50)->nullable()->unique();

            $table->integer('capacity')->default(0);
            $table->year('manufacture_year')->nullable();

            $table->enum('status', [
                'available',
                'on_trip',
                'maintenance',
                'inactive'
            ])->default('available');

            $table->date('last_service_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['operator_id', 'transport_mode_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};