<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ConsultantProfile;

class CompleteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating complete user accounts...\n\n";

        // Create Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('admin123'),
                'role' => 'Admin',
                'email_verified_at' => now(),
            ]
        );
        echo "✅ Admin Account: admin1@gmail.com (admin123)\n";

        // Create Customer Account
        $customer = User::firstOrCreate(
            ['email' => 'customer1@gmail.com'],
            [
                'name' => 'Test Customer',
                'password' => bcrypt('customer123'),
                'role' => 'Customer',
                'email_verified_at' => now(),
            ]
        );
        echo "✅ Customer Account: customer1@gmail.com (customer123)\n";

        // Create Consultant Account
        $consultant = User::firstOrCreate(
            ['email' => 'consultant1@gmail.com'],
            [
                'name' => 'Test Consultant',
                'password' => bcrypt('consultant123'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ]
        );

        // Create consultant profile
        ConsultantProfile::firstOrCreate(
            ['user_id' => $consultant->id],
            [
                'full_name' => 'Test Consultant',
                'email' => 'consultant1@gmail.com',
                'phone_number' => '+1-555-123-4567',
                'expertise' => 'Business Strategy',
                'address' => '123 Business St, New York, NY 10001',
                'age' => 35,
                'sex' => 'Male',
                'resume_path' => 'sample-resume.pdf',
                'is_verified' => true,
                'rules_accepted' => true,
            ]
        );
        echo "✅ Consultant Account: consultant1@gmail.com (consultant123)\n";

        echo "\n📊 Account Summary:\n";
        echo "Total Users: " . User::count() . "\n";
        echo "Admins: " . User::where('role', 'Admin')->count() . "\n";
        echo "Customers: " . User::where('role', 'Customer')->count() . "\n";
        echo "Consultants: " . User::where('role', 'Consultant')->count() . "\n";
        echo "Verified Consultants: " . ConsultantProfile::where('is_verified', true)->count() . "\n";

        echo "\n🔑 Login Credentials:\n";
        echo "Admin: admin1@gmail.com / admin123\n";
        echo "Customer: customer1@gmail.com / customer123\n";
        echo "Consultant: consultant1@gmail.com / consultant123\n";
    }
}
