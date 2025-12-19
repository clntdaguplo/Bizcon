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
        // Drop the foreign key constraint
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->dropForeign(['consultation_id']);
        });

        // Update enum type to include new payment notification types using raw SQL
        DB::statement("ALTER TABLE consultation_notifications 
                       MODIFY type ENUM('reminder_24h', 'reminder_1h', 'proposal', 'status_change', 'account_welcome', 'consultant_approved', 'consultant_rejected', 'consultant_update_approved', 'consultant_update_rejected', 'consultant_suspended', 'consultant_unsuspended', 'payment_approved', 'payment_rejected') NOT NULL");

        // Re-add the foreign key constraint
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

        // Revert enum type to previous version using raw SQL
        DB::statement("ALTER TABLE consultation_notifications 
                       MODIFY type ENUM('reminder_24h', 'reminder_1h', 'proposal', 'status_change', 'account_welcome', 'consultant_approved', 'consultant_rejected', 'consultant_update_approved', 'consultant_update_rejected', 'consultant_suspended', 'consultant_unsuspended') NOT NULL");

        // Re-add the foreign key constraint
        Schema::table('consultation_notifications', function (Blueprint $table) {
            $table->foreign('consultation_id')
                  ->references('id')
                  ->on('consultations')
                  ->onDelete('cascade');
        });
    }
};
