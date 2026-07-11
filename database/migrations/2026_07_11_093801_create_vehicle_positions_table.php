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
        Schema::create('vehicle_positions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->foreignId('trip_id')
                ->nullable()
                ->constrained('trips')
                ->nullOnDelete();


            // GPS Position
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);


            // Movement Data
            $table->decimal('speed_kmh', 6, 2)
                ->default(0);

            $table->unsignedSmallInteger('heading_degree')
                ->nullable();


            // GPS Accuracy
            $table->decimal('accuracy_meter', 8, 2)
                ->nullable();


            // Vehicle Status
            $table->enum('status', [
                'moving',
                'idle',
                'stopped'
            ])
                ->default('stopped');


            // GPS Time
            $table->dateTime('recorded_at');


            $table->timestamps();


            // Index
            $table->index([
                'vehicle_id',
                'recorded_at'
            ]);

            $table->index([
                'latitude',
                'longitude'
            ]);

            $table->index([
                'trip_id',
                'recorded_at'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_positions');
    }
};
