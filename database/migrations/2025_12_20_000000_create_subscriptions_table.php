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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('plan_type', ['free_trial', 'pro']);
            $table->enum('status', ['active', 'pending', 'expired', 'rejected'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'approved', 'rejected', 'not_required'])->default('pending');
            $table->string('proof_path')->nullable();
            $table->integer('minutes_total')->nullable();
            $table->integer('minutes_used')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

