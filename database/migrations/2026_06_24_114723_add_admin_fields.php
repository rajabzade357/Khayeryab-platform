<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ۱. اضافه کردن is_active به users (اگه نداری)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('phone_verified_at');
            }
        });

        // ۲. جدول تخلفات
        if (!Schema::hasTable('violations')) {
            Schema::create('violations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
                $table->integer('count')->default(1); // تعداد تخلف (میتونه منفی باشه برای کم کردن)
                $table->string('reason')->nullable(); // دلیل تخلف
                $table->string('type')->default('manual'); // manual, auto
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_active']);
        });

        Schema::dropIfExists('violations');
    }
};