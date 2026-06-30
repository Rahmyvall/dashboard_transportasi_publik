<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('operator_id')
                ->constrained('operators')
                ->cascadeOnDelete();

            $table->foreignId('transport_mode_id')
                ->constrained('transport_modes')
                ->cascadeOnDelete();

            $table->string('route_code', 50)->unique();
            $table->string('route_name', 150);
            $table->string('origin', 150);
            $table->string('destination', 150);

            $table->decimal('distance_km', 8, 2)->nullable();
            $table->integer('estimated_duration_minutes')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
                'maintenance'
            ])->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['operator_id', 'transport_mode_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};