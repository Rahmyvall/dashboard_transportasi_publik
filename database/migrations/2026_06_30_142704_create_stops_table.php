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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();

            $table->string('stop_code', 50)->unique();
            $table->string('stop_name', 150);

            $table->enum('stop_type', [
                'halte',
                'terminal',
                'shelter',
                'stasiun'
            ])->default('halte');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->text('address')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['latitude', 'longitude']);
            $table->index('is_active');
        });
    }

    /**
     * Membatalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};