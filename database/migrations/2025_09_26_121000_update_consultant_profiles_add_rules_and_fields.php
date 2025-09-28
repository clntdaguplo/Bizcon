<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultant_profiles', function (Blueprint $table) {
            $table->boolean('rules_accepted')->default(false)->after('is_verified');
            $table->string('full_name')->nullable()->after('rules_accepted');
            $table->string('phone_number')->nullable()->after('full_name');
            $table->string('email')->nullable()->after('phone_number');
            $table->string('expertise')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('consultant_profiles', function (Blueprint $table) {
            $table->dropColumn(['rules_accepted', 'full_name', 'phone_number', 'email', 'expertise']);
        });
    }
};


