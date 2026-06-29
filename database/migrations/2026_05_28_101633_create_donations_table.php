<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('charity_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['small', 'large'])->default('small');
            $table->json('images')->nullable();
            $table->enum('delivery_method', ['charity_location', 'donor_location']);
            $table->date('pickup_date')->nullable();
            $table->string('status', 50)->default('waiting_for_charity'); // تغییر از ENUM به VARCHAR
            $table->text('rejection_reason')->nullable(); // اضافه کردن دلیل رد
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};