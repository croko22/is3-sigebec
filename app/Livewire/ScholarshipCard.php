<?php

namespace App\Livewire;

use App\Models\Scholarship;
use Livewire\Component;

class scholarshipCard extends Component
{
    public $scholarship;

    public function mount($scholarship)
    {
        $this->scholarship = $scholarship;
    }
    public function render()
    {
        return view('livewire.scholarship-card', [
            'scholarship' => $this->scholarship
        ]);
    }
}
