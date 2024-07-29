<?php

namespace App\Livewire\Modals;

use Livewire\Attributes\On;
use Livewire\Component;

class Createapplicant extends Component
{
    public $modalOpen = false;


    #[On('applicant-added')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }
    public function render()
    {
        return view('livewire.modals.create-applicant');
    }
}
