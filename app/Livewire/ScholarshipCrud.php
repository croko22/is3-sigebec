<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Scholarship;

#[On('scholarship-created')]
#[Layout('components.layouts.app')]
class ScholarshipCrud extends Component
{
    use WithPagination;
    public string $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $searchTerm = '%' . $this->query . '%';

        $scholarships = Scholarship::where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            })
            ->paginate(10);
        return view('livewire.scholarship-crud', compact('scholarships'));
    }

    public function deleteScholarship(int $scholarshipId)
    {
        Scholarship::destroy($scholarshipId);
        $this->dispatch('scholarship-deleted', ['message' => 'scholarship deleted successfully!'])->self();
    }
}