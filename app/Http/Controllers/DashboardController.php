<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Scholarship;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $scholarships = Scholarship::orderBy('updated_at', 'desc')->take(10)->get();
        } else {
            // $scholarships = auth()->user()->scholarship;
            $scholarships = [];
        }

        $applicants = User::role('applicant')->take(6)->get();
        $applicantsCount = User::role('applicant')->count();
        $scholarshipsCount = Scholarship::count();

        return view('dashboard', compact('scholarships', 'scholarshipsCount', 'applicantsCount', 'applicants'));
    }
}