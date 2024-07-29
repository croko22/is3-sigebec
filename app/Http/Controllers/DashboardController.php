<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Scholarship;
use App\Models\ScholarshipCall;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicantsCount = User::role('applicant')->count();
        $scholarshipsCount = Scholarship::count();
        
        $allCalls = ScholarshipCall::with(['scholarship'])->where('end_date', '>=', Carbon::now())->get();
        
        if (auth()->user()->hasRole('admin')) {
            $applicants = User::role('applicant')->take(6)->get();
            $scholarships = $allCalls;

            return view('dashboard', compact('scholarships', 'scholarshipsCount', 'applicantsCount', 'applicants'));
        } else {
            $scholarships = $allCalls->where('start_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now());
            $scholarshipsFutures = $allCalls->where('start_date', '>', Carbon::now());
            
            return view('dashboard', compact('scholarships','scholarshipsFutures' , 'scholarshipsCount', 'applicantsCount'));
        }

    }
}