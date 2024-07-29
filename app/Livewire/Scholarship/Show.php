<?php

namespace App\Livewire\scholarship;

use App\Models\Scholarship;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public scholarship $scholarship;
    public $name;
    public $description;
    public $applicants;
    public $selectedapplicant;
    public $students;
    public $selectedNewStudent;

    public function mount(scholarship $scholarship)
    {
        $this->scholarship = $scholarship;
        $this->name = $scholarship->name;
        $this->description = $scholarship->description;
        $this->applicants = User::applicants()->get() ?? [];
        // $this->selectedapplicant = $this->scholarship->applicants->first()->id ?? null;
        // $this->students = Student::all();
    }

    public function render()
    {
        return view('livewire.scholarship.show', [
            'scholarship' => $this->scholarship,
            'applicants' => $this->applicants,
            'students' => $this->students,
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->scholarship->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('scholarship-updated', ['message' => 'scholarship updated successfully!']);

    }

    public function addStudent()
    {
        $this->validate([
            'selectedNewStudent' => 'required',
        ]);

        $this->scholarship->students()->attach($this->selectedNewStudent);
        $this->dispatch('scholarship-updated', ['message' => 'Student added successfully!']);
    }

    public function removeStudent($studentId)
    {
        $this->scholarship->students()->detach($studentId);
        $this->scholarship = scholarship::find($this->scholarship->id);
    }
}
