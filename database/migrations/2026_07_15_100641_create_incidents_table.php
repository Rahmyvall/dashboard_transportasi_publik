<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relasi
            |--------------------------------------------------------------------------
            */

            $table->foreignId('trip_id')
                ->nullable()
                ->constrained('trips')
                ->nullOnDelete();

            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles')
                ->nullOnDelete();

            $table->foreignId('route_id')
                ->nullable()
                ->constrained('routes')
                ->nullOnDelete();

            $table->foreignId('reported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Informasi kejadian
            |--------------------------------------------------------------------------
            */

            $table->enum('incident_type', [
                'accident',
                'breakdown',
                'traffic',
                'weather',
                'security',
                'other',
            ])->default('other');

            $table->string('title', 150);
            $table->text('description')->nullable();

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('low');

            $table->enum('status', [
                'open',
                'in_progress',
                'resolved',
                'closed',
            ])->default('open');

            /*
            |--------------------------------------------------------------------------
            | Lokasi kejadian
            |--------------------------------------------------------------------------
            */

            $table->decimal('location_latitude', 10, 7)->nullable();
            $table->decimal('location_longitude', 10, 7)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Waktu kejadian
            |--------------------------------------------------------------------------
            */

            $table->dateTime('reported_at');
            $table->dateTime('resolved_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index(
                ['incident_type', 'severity'],
                'incidents_type_severity_index'
            );

            $table->index(
                ['status', 'reported_at'],
                'incidents_status_reported_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
