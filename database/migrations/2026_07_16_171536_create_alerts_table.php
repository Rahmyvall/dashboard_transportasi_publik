<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration.
     */
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relasi
            |--------------------------------------------------------------------------
            |
            | Pastikan tabel incidents, routes, dan vehicles sudah dibuat
            | sebelum migration alerts dijalankan.
            |
            */

            $table->foreignId('incident_id')
                ->nullable()
                ->constrained('incidents')
                ->nullOnDelete();

            $table->foreignId('route_id')
                ->nullable()
                ->constrained('routes')
                ->nullOnDelete();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informasi Alert
            |--------------------------------------------------------------------------
            */

            $table->string('title', 150);
            $table->text('message');

            $table->enum('alert_type', [
                'delay',
                'diversion',
                'service_stop',
                'crowded',
                'emergency',
                'info',
            ])->default('info');

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('low');

            /*
            |--------------------------------------------------------------------------
            | Status Publikasi
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_published')->default(false);

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamp('expired_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index(
                ['alert_type', 'priority'],
                'alerts_type_priority_index'
            );

            $table->index(
                ['is_published', 'published_at'],
                'alerts_publication_index'
            );

            $table->index(
                'expired_at',
                'alerts_expired_at_index'
            );
        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
