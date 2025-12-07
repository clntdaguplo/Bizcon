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
        Schema::table('consultant_profiles', function (Blueprint $table) {
            $table->boolean('has_pending_update')->default(false)->after('suspended_until');
            $table->timestamp('update_requested_at')->nullable()->after('has_pending_update');
            $table->json('previous_values')->nullable()->after('update_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultant_profiles', function (Blueprint $table) {
            $table->dropColumn(['has_pending_update', 'update_requested_at', 'previous_values']);
        });
    }
};
