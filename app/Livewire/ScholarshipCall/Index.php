<?php

namespace App\Livewire\ScholarshipCall;


use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ScholarshipCall;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $query = '';
    public function render()
    {
        $calls = ScholarshipCall::paginate(7);
        return view('livewire.scholarship-call.index', compact('calls'));
    }
}