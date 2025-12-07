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
            $table->timestamp('rejected_at')->nullable()->after('admin_note');
            $table->timestamp('resubmitted_at')->nullable()->after('rejected_at');
            $table->integer('resubmission_count')->default(0)->after('resubmitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultant_profiles', function (Blueprint $table) {
            $table->dropColumn(['rejected_at', 'resubmitted_at', 'resubmission_count']);
        });
    }
};

