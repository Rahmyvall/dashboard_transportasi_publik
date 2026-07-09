<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            $table->foreignId('schedule_id')
                ->nullable()
                ->constrained('schedules')
                ->nullOnDelete();

            $table->foreignId('route_id')
                ->constrained('routes')
                ->cascadeOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers')
                ->nullOnDelete();

            $table->string('trip_code', 100)->unique();

            $table->dateTime('planned_start_time');
            $table->dateTime('planned_end_time')->nullable();

            $table->dateTime('actual_start_time')->nullable();
            $table->dateTime('actual_end_time')->nullable();

            $table->enum('status', [
                'scheduled',
                'running',
                'completed',
                'cancelled',
                'delayed',
            ])->default('scheduled');

            $table->integer('delay_minutes')->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['route_id', 'vehicle_id']);
            $table->index(['status', 'planned_start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};