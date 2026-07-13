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
        Schema::create('passenger_counts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('trip_id')
                ->constrained('trips')
                ->cascadeOnDelete();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->foreignId('stop_id')
                ->nullable()
                ->constrained('stops')
                ->nullOnDelete();


            $table->unsignedInteger('boarding_count')
                ->default(0);

            $table->unsignedInteger('alighting_count')
                ->default(0);

            $table->unsignedInteger('current_load')
                ->default(0);


            $table->unsignedInteger('vehicle_capacity')
                ->nullable();


            $table->dateTime('recorded_at');


            $table->timestamps();


            $table->index([
                'trip_id',
                'vehicle_id',
                'stop_id'
            ]);

            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passenger_counts');
    }
};
