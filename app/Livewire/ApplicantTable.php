<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Applicant;

#[Layout('components.layouts.app')]
class ApplicantTable extends Component
{
    use WithPagination;

    public $query = '';
    public $selectedRows = [];

    public $name;
    public $email;

    public function search()
    {
        $this->resetPage();
    }


    public function render()
    {
        $applicants = Applicant::paginate(7);
        return view('livewire.applicant-table', compact('applicants'));
    }

    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            return;
        }
        User::destroy($this->selectedRows);
        $this->selectedRows = [];

        $this->dispatch('applicant-deleted', ['message' => 'applicants deleted successfully!']);
    }

    public function createapplicant()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required | email',
        ]);

        $applicant = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ]);
        $applicant->assignRole('applicant');

        $this->reset();
        $this->dispatch('applicant-added', ['message' => 'applicant added successfully!']);
    }

}
