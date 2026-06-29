<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('phone_verifications')) {
            Schema::create('phone_verifications', function (Blueprint $table) {
                $table->id();
                $table->string('phone', 11);
                $table->string('code', 6);
                $table->timestamp('expires_at');
                $table->timestamps();
                $table->index('phone');
                $table->index('expires_at');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'mobile')) {
                $table->string('mobile', 11)->nullable()->unique()->after('phone');
            }
            if (!Schema::hasColumn('users', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('mobile');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'phone_verified_at']);
        });
        Schema::dropIfExists('phone_verifications');
    }
};