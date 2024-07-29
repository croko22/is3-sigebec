<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\Scholarship;
use App\Models\ScholarshipCall;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('admin');

        $applicants = User::factory(10)->create();
        $applicants->each(function ($applicant) {
            $applicant->assignRole('applicant');
        });

        Scholarship::factory()->createMany(
            [
                ['name' => 'Scholarship 1', 'description' => 'Description 1'],
                ['name' => 'Scholarship 2', 'description' => 'Description 2'],
                ['name' => 'Scholarship 3', 'description' => 'Description 3'],
            ]
        )->each(function ($scholarship) {
            ScholarshipCall::factory()->createMany([
                [
                'name' => $scholarship->name . ' Call',
                'description' => 'Description for ' . $scholarship->name . ' Call',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(10),
                'scholarship_id' => $scholarship->id,
                ],
                [
                'name' => $scholarship->name . ' Call',
                'description' => 'Description for ' . $scholarship->name . ' Call',
                'start_date' => now()->addMonth(),
                'end_date' => now()->addMonths(2),
                'scholarship_id' => $scholarship->id,
                ]
        ]);
        });
        
        $this->call(ApplicantSeeder::class);
    }
}