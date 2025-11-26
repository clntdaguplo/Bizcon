<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = User::where('email', 'admin1@gmail.com')->first();
        
        if ($existingAdmin) {
            echo "Admin account already exists!\n";
            return;
        }

        // Create the admin account
        User::create([
            'name' => 'Test Admin',
            'email' => 'admin1@gmail.com',
            'password' => 'admin123',
            'role' => 'Admin',
            'email_verified_at' => now(),
        ]);

        echo "Admin account created successfully!\n";
        echo "Email: admin1@gmail.com\n";
        echo "Password: admin123\n";
    }
}
