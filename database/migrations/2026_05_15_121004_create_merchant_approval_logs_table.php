<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_approval_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('action', ['approved', 'rejected', 'suspended', 'reactivated']);
            $table->text('note')->nullable(); // Catatan opsional dari admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_approval_logs');
    }
};
