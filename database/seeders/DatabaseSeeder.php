<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Scholarship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'test@example.com',
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
    }
}
