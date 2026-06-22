<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // USERS TABLE
        // =========================
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('operators')->nullOnDelete();

            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('email', 100)->nullable();
            $table->string('password', 255);

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            // ✅ FIX PENTING: tambahkan timestamps full Laravel
            $table->timestamps();
        });

        // =========================
        // PASSWORD RESET TOKENS
        // =========================
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // =========================
        // SESSIONS TABLE
        // =========================
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();

            $table->foreignId('user_id')->nullable()->index();

            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};