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
        // ایجاد جدول phone_verifications
        if (!Schema::hasTable('phone_verifications')) {
            Schema::create('phone_verifications', function (Blueprint $table) {
                $table->id();
                $table->string('phone', 11)->comment('شماره موبایل');
                $table->string('code', 6)->comment('کد تأیید ۶ رقمی');
                $table->timestamp('expires_at')->comment('زمان انقضای کد');
                $table->timestamps();

                // ایندکس برای جستجوی سریع‌تر
                $table->index('phone');
                $table->index('expires_at');
            });
        }

        // اضافه کردن فیلدهای جدید به جدول users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'mobile')) {
                $table->string('mobile', 11)
                    ->nullable()
                    ->unique()
                    ->after('phone')
                    ->comment('شماره موبایل جهت تأیید پیامکی');
            }

            if (!Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')
                    ->nullable()
                    ->after('mobile')
                    ->comment('زمان تأیید شماره موبایل');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف فیلدهای اضافه شده از users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'phone_verified_at']);
        });

        // حذف جدول phone_verifications
        Schema::dropIfExists('phone_verifications');
    }
};