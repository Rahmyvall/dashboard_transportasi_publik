<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_stops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('route_id')
                ->constrained('routes')
                ->cascadeOnDelete();

            $table->foreignId('stop_id')
                ->constrained('stops')
                ->cascadeOnDelete();

            $table->integer('stop_order');

            $table->decimal('distance_from_start_km', 8, 2)
                ->nullable();

            $table->integer('estimated_arrival_minutes')
                ->nullable();

            $table->timestamps();

            $table->unique(['route_id', 'stop_id']);
            $table->unique(['route_id', 'stop_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_stops');
    }
};