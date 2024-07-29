<?php

namespace App\Livewire\Modals;

use Livewire\Component;

class ViewScholarship extends Component
{
    public $scholarship;

    public function mount($scholarship)
    {
        $this->scholarship = $scholarship;
    }

    public function render()
    {
        return view('livewire.modals.view-scholarship', [
            'scholarship' => $this->scholarship
        ]);
    }
}
