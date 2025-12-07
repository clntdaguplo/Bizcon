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
        Schema::create('consultant_suspension_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultant_profile_id')->constrained('consultant_profiles')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('action', ['suspended', 'unsuspended']); // Action type
            $table->enum('duration', ['12hrs', '1day', '3days', '7days', 'permanent'])->nullable(); // Original suspension duration
            $table->timestamp('suspended_until')->nullable(); // When suspension was set to expire
            $table->timestamp('action_date')->nullable(); // When the action was taken
            $table->text('reason')->nullable(); // Optional reason/note
            $table->timestamps();
            
            $table->index('consultant_profile_id');
            $table->index('action_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_suspension_history');
    }
};
