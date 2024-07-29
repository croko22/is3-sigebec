<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipCall extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'course_id'];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function attendanceCount()
    {
        return $this->attendance->count();
    }

    // public function applicants()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
