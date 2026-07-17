<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->enum('maintenance_type', [
                'routine',
                'repair',
                'inspection',
                'emergency',
            ])->default('routine');

            $table->text('description')->nullable();

            $table->decimal('cost', 12, 2)
                ->default(0);

            $table->date('maintenance_date');

            $table->date('next_maintenance_date')
                ->nullable();

            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('scheduled');

            $table->string('handled_by', 150)
                ->nullable();

            $table->timestamps();

            $table->index([
                'vehicle_id',
                'maintenance_date',
            ]);

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};