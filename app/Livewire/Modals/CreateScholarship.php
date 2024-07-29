<?php

namespace App\Livewire\Modals;

use App\Models\Scholarship;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateScholarship extends Component
{
    #[Validate('required')]
    public string $name;
    #[Validate('required')]
    public string $description;
    public bool $modalOpen = false;

    #[On('scholarship-created')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function render()
    {
        return view('livewire.modals.create-scholarship');
    }

    public function createscholarship()
    {
        $this->validate();
        Scholarship::create($this->pull());
        $this->reset();
        $this->description = '';
        $this->dispatch('scholarship-created', ['message' => 'Scholarship created successfully!']);
    }
}
