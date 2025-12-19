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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Update enum for plan_type by converting to string first
            $table->string('plan_type')->change(); 
            $table->string('support_priority')->default('low')->after('plan_type');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('support_priority');
            // Revert plan_type if possible, but keeping it as string is safer
        });
    }
};
