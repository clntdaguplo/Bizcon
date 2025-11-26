<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ConsultantProfile;

class ConsultantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample consultant users
        $consultants = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'password' => bcrypt('password'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => bcrypt('password'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'password' => bcrypt('password'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => bcrypt('password'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@example.com',
                'password' => bcrypt('password'),
                'role' => 'Consultant',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($consultants as $consultantData) {
            $user = User::create($consultantData);
            
            // Create consultant profile
            ConsultantProfile::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
                'phone_number' => '+1-555-' . rand(100, 999) . '-' . rand(1000, 9999),
                'expertise' => $this->getRandomExpertise(),
                'address' => $this->getRandomAddress(),
                'age' => rand(25, 65),
                'sex' => ['Male', 'Female', 'Other'][rand(0, 2)],
                'resume_path' => 'sample-resume.pdf',
                'is_verified' => true,
                'rules_accepted' => true,
            ]);
        }
    }

    private function getRandomExpertise()
    {
        $expertises = [
            'Business Strategy',
            'Marketing & Sales',
            'Financial Planning',
            'Operations Management',
            'Digital Transformation',
            'Human Resources',
            'Project Management',
            'Technology Consulting',
            'Supply Chain Management',
            'Risk Management'
        ];
        
        return $expertises[array_rand($expertises)];
    }

    private function getRandomAddress()
    {
        $addresses = [
            '123 Business St, New York, NY 10001',
            '456 Corporate Ave, Los Angeles, CA 90210',
            '789 Enterprise Blvd, Chicago, IL 60601',
            '321 Innovation Dr, Austin, TX 73301',
            '654 Success Way, Seattle, WA 98101'
        ];
        
        return $addresses[array_rand($addresses)];
    }
}
