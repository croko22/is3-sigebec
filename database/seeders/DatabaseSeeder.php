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
        );

        $scholarships = Scholarship::all();

        $scholarships->each(function ($scholarship) {
            ScholarshipCall::create([
                'name' => $scholarship->name . ' Call',
                'description' => 'Description for ' . $scholarship->name . ' Call',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'scholarship_id' => $scholarship->id,
            ]);
        });
        
        $this->call(ApplicantSeeder::class);
    }
}
