<?php

namespace App\Livewire\Modals;

use App\Models\Scholarship;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateLesson extends Component
{
    public $scholarship;
    #[Validate('required')]
    public $start_date = null;
    #[Validate('required')]
    public $end_date = null;
    public $modalOpen = false;


    #[On('lesson-created')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    public function mount(scholarship $scholarship)
    {
        $this->scholarship = $scholarship;
    }

    public function render()
    {
        return view('livewire.modals.create-lesson');
    }

    // public function createLesson()
    // {
    //     $specificDate = $this->date . ' ' . $this->time;
    //     $this->scholarship->lessons()->create([
    //         'date' => $specificDate,
    //     ]);

    //     $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
    //     $this->modalOpen = false;
    //     $this->reset();
    // }
}
