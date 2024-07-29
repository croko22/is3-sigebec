<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

#[On('user-updated')]
class applicantRow extends Component
{
    public $applicant;

    public function mount($applicant)
    {
        $this->applicant = $applicant;
    }
    public function render()
    {
        
        return view('livewire.applicant-row', [
            'applicant' => $this->applicant
        ]);
    }
}
