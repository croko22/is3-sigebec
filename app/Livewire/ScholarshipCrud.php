<?php

namespace App\Livewire;

use App\Models\User;
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
        $user = User::find(auth()->user()->id);

        $query = Scholarship::query();
        $query->where('name', 'like', $searchTerm)
            ->orWhere('description', 'like', $searchTerm);

        $scholarships = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('livewire.scholarship-crud', compact('scholarships'));
    }

    public function deletescholarship(int $scholarshipId)
    {
        Scholarship::destroy($scholarshipId);
        $this->dispatch('scholarship-deleted', ['message' => 'scholarship deleted successfully!'])->self();
    }
}