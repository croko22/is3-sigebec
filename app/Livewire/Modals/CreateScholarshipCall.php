<?php

namespace App\Livewire\Modals;

use App\Models\Scholarship;
use App\Models\ScholarshipCall;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateScholarshipCall extends Component
{
    #[Validate('required')]
    public $start_date = null;
    #[Validate('required')]
    public $end_date = null;
    #[Validate('required')]
    public string $selectedScholarship="";
    public bool $modalOpen = false;
    public $scholarships;

    #[On('scholarship-call-created')]
    public function closeModal()
    {
        $this->modalOpen = false;
    }

    // public function mount()
    // // public function mount($scholarships)
    // {
    //     $this->scholarships = Scholarship::all();
    // }

    public function render()
    {
        return view('livewire.modals.create-scholarship-call', [
            $this->scholarships = Scholarship::all(),
        ]);
    }

    public function createScholarshipCall()
    {
        $this->validate();
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $beca = Scholarship::find((int)$this->selectedScholarship);
        $month = date('m', strtotime($this->start_date));
        $becaName = $beca?->name." - ".$meses[$month-1];
        $this->selectedScholarship = (int) $this->selectedScholarship;
        ScholarshipCall::create([
            'name'=>$becaName,
            'description' => '',
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'scholarship_id' => $this->selectedScholarship,
        ]);
        // ScholarshipCall::create($this->pull());
        // dd($this->pull());
        $this->reset();
        $this->description = '';
        $this->dispatch('scholarship-call-created', ['message' => 'Scholarship call created successfully!']);
    }
}