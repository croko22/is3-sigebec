<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Livewire\ApplicantTable;
use App\Livewire\ScholarshipCrud;
use App\Livewire\Scholarship\Show as ScholarshipShow;
use App\Livewire\Scholarship\Call as ScholarshipCall;
use App\Livewire\Attendance\Index as AttendanceIndex;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/scholarship', ScholarshipCrud::class)->name('scholarship');
    Route::get('/scholarship/{scholarship}', ScholarshipShow::class)->name('scholarship.show');
    Route::get('/scholarshipcall/{scholarshipcall}', ScholarshipCall::class)->name('scholarship.call');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/applicant', ApplicantTable::class)->name('applicant');
    });

    Route::group(['middleware' => ['role:teacher']], function () {
        Route::get('/attendance/{scholarship}', AttendanceIndex::class)->name('attendance');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::view('/', 'welcome')->name('home');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->middleware('guest')->name('password.update');
});