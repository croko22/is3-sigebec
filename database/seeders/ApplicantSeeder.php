<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Applicant;
use App\Models\User;
use App\Models\ScholarshipCall;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $scholarshipCalls = ScholarshipCall::pluck('id')->toArray();

        foreach ($scholarshipCalls as $scholarshipCall) {
            for ($i = 0; $i < 3; $i++) {
                Applicant::create([
                    'user_id' => $users[array_rand($users)],
                    'scholarship_call_id' => $scholarshipCall,
                    'status' => 'pending',
                    'start_date' => now(),
                ]);
            }
        }
    }
}
