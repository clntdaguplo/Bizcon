    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            // Proposed schedule fields (when consultant proposes new time)
            if (Schema::hasColumn('consultations', 'scheduled_date')) {
                $table->date('proposed_date')->nullable()->after('scheduled_date');
            } else {
                $table->date('proposed_date')->nullable();
            }
            
            if (Schema::hasColumn('consultations', 'scheduled_time')) {
                $table->time('proposed_time')->nullable()->after('scheduled_time');
            } else {
                $table->time('proposed_time')->nullable();
            }
            
            if (Schema::hasColumn('consultations', 'status')) {
                $table->string('proposal_status')->nullable()->after('status'); // null, 'pending', 'accepted', 'declined'
            } else {
                $table->string('proposal_status')->nullable();
            }
            
            // Report fields
            $table->text('consultation_summary')->nullable();
            $table->text('recommendations')->nullable();
            $table->integer('client_readiness_rating')->nullable(); // 1-5
            $table->string('report_file_path')->nullable();
        });

        // Create ratings table
        Schema::create('consultation_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->cascadeOnDelete();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete(); // who is rating
            $table->enum('rater_type', ['customer', 'consultant']);
            $table->integer('rating')->default(1); // 1-5 stars
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // Ensure one rating per consultation per rater type
            $table->unique(['consultation_id', 'rater_id', 'rater_type']);
        });

        // Create notifications table for reminders
        Schema::create('consultation_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['reminder_24h', 'reminder_1h', 'proposal', 'status_change']);
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_notifications');
        Schema::dropIfExists('consultation_ratings');
        
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn([
                'proposed_date',
                'proposed_time',
                'proposal_status',
                'consultation_summary',
                'recommendations',
                'client_readiness_rating',
                'report_file_path'
            ]);
        });
    }
};

