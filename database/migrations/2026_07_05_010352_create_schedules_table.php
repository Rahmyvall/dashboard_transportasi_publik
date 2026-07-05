<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('route_id')
                ->constrained('routes')
                ->cascadeOnDelete();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles')
                ->nullOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers')
                ->nullOnDelete();

            $table->enum('day_type', [
                'weekday',
                'weekend',
                'holiday',
                'all'
            ])->default('all');

            $table->time('start_time');
            $table->time('end_time');

            $table->integer('headway_minutes')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['route_id', 'day_type']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};