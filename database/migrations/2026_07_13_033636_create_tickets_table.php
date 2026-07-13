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
        Schema::create('tickets', function (Blueprint $table) {

            $table->id();


            $table->foreignId('trip_id')
                ->nullable()
                ->constrained('trips')
                ->nullOnDelete();


            $table->foreignId('route_id')
                ->nullable()
                ->constrained('routes')
                ->nullOnDelete();


            $table->foreignId('vehicle_id')
                ->nullable()
                ->constrained('vehicles')
                ->nullOnDelete();



            $table->string('ticket_code', 100)
                ->unique();



            $table->enum('payment_method', [
                'cash',
                'emoney',
                'qris',
                'card',
                'other'
            ])
                ->default('emoney');



            $table->decimal('fare', 12, 2)
                ->default(0);



            $table->enum('ticket_status', [
                'paid',
                'refunded',
                'failed'
            ])
                ->default('paid');



            $table->dateTime('issued_at');


            $table->timestamps();



            $table->index([
                'trip_id',
                'route_id',
                'vehicle_id'
            ]);


            $table->index('issued_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
