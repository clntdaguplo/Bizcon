<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, drop the foreign key constraint
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
        });

        // Make consultation_id nullable and update enum type using raw SQL
        DB::statement("ALTER TABLE consultation_notifications 
                       MODIFY consultation_id BIGINT UNSIGNED NULL,
                       MODIFY type ENUM('reminder_24h', 'reminder_1h', 'proposal', 'status_change', 'account_welcome', 'consultant_approved', 'consultant_rejected') NOT NULL");

        // Re-add the foreign key constraint with nullable support
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraint
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
        });

        // Revert consultation_id to not nullable and enum type to original using raw SQL
        DB::statement("ALTER TABLE consultation_notifications 
                       MODIFY consultation_id BIGINT UNSIGNED NOT NULL,
                       MODIFY type ENUM('reminder_24h', 'reminder_1h', 'proposal', 'status_change') NOT NULL");

        // Re-add the foreign key constraint
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');
        });
    }
};

