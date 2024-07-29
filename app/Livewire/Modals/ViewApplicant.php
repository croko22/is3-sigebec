<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class ViewApplicant extends Component
{
    public $applicant;

    public function mount($applicant)
    {
        $this->applicant = $applicant;
    }

    public function render()
    {
        return view('livewire.modals.view-applicant' , [
            'applicant' => $this->applicant
        ]);
    }

    public function aceptapplicant()
    {
        $this->applicant->update([
            'status' => 'accepted'
        ]);
        $this->dispatch('user-updated', ['message' => 'user updated successfully!']);
    }

    public function rejectapplicant()
    {
        $this->applicant->update([
            'status' => 'rejected'
        ]);
    }
}
