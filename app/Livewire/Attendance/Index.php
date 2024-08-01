<?php

namespace App\Livewire\Attendance;

use App\Models\Scholarship;
use App\Models\ScholarshipCall as Call;
use App\Models\Lesson;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public Scholarship $scholarship;
    public string $filter = '';
    public function addFilter($filter)
    {
        $this->filter = $this->filter==''||$this->filter!=$filter? $filter:'';
    }
    public function mount($scholarship)
    {
        $this->scholarship = $scholarship;
    }

    public function render()
    {
        return view('livewire.attendance.index', [
            'calls' => Call::where('scholarship_id',$this->scholarship['id'])->
            when($this->filter, function ($query) {
                match ($this->filter) {
                    'active' => $query->where('start_date', '<=', now())->where('end_date', '>=', now()),
                    'upcoming' => $query->where('start_date', '>', now()),
                    'past' => $query->where('end_date', '<', now()),
                    default => $query,
                };
                return $query;
            })->paginate(11),
        ]);
    }
    
    /*
    #[On("lesson-created")]
    public function createLesson()
    {
        $this->scholarship->calls()->create([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->dispatch('lesson-created', ['message' => 'Lesson created successfully!']);
        $this->modalOpen = false;
        // $this->reset();
    }
    public function deleteMarked()
    {
        if (empty($this->selectedRows)) {
            return;
        }
        Lesson::destroy($this->selectedRows);
        $this->selectedRows = [];

        $this->dispatch('lesson-deleted', ['message' => 'Lessons deleted successfully!']);
    }*/
}