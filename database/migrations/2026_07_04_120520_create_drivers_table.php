<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('operator_id')
                ->constrained('operators')
                ->cascadeOnDelete();

            $table->string('driver_name', 150);
            $table->string('license_number', 100)->unique();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
                'on_duty'
            ])->default('active');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['operator_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};