<?php

namespace App\Livewire\ScholarshipCall;

use Livewire\Component;
use App\Models\ScholarshipCall;

class Edit extends Component
{
    public ScholarshipCall $scholarshipCall;
    public $name = '';
    public $description = '';

    public function mount(ScholarshipCall $scholarshipcall)
    {
        $this->scholarshipCall = $scholarshipcall;
        $this->name = $scholarshipcall->name;
        $this->description = $scholarshipcall->description;
    }

    public function render()
    {
        return view('livewire.scholarship-call.edit' , [
            'scholarshipcall' => $this->scholarshipCall
        ]);
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->scholarshipCall->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('scholarship-updated', ['message' => 'user updated successfully!']);
    }
}
