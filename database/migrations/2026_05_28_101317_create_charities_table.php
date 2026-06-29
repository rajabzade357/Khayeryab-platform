<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
 {
    Schema::create('charities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('registration_number')->nullable();
        $table->string('national_id', 11)->nullable()->unique();
        $table->string('manager_name')->nullable();
        $table->string('license_number')->nullable();
        $table->string('license_image')->nullable();
        $table->string('national_card_image')->nullable();
        $table->string('bank_account_number')->nullable();
        $table->string('iban')->nullable();
        $table->string('logo')->nullable();
        $table->boolean('is_approved')->default(false);
        $table->text('description')->nullable();
        $table->timestamps();
    });
  }

    public function down(): void
    {
        Schema::dropIfExists('charities');
    }
};