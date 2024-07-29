<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

#[On("attendance-updated")]
class LessonRow extends Component
{
    public $lesson;
    public $scholarship;

    public function mount($lesson, $scholarship)
    {
        $this->lesson = $lesson;
        $this->scholarship = $scholarship;
    }
    public function render()
    {
        return view('livewire.lesson-row', ['lesson' => $this->lesson]);
    }
}
