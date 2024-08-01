<?php

namespace App\Livewire\ScholarshipCall;

use App\Models\ScholarshipCall;
use Livewire\Component; 
use App\Models\User;
use App\Models\Applicant;
use App\Helpers\MailHelper;

class Call extends Component
{
    public $userEmail;
    public $userPassword;
    public $userPasswordConfirmation;
    public $userDescription;
    public ScholarshipCall $scholarshipCall;

    public function mount(ScholarshipCall $scholarshipcall)
    {
        $this->scholarshipCall = $scholarshipcall;
    }

    public function rules()
    {
        return [
            'userEmail' => 'required|email',
            'userPassword' => 'required',
            'userPasswordConfirmation' => 'required|same:userPassword',
        ];
    }

    public function render()
    {
        return view('livewire.scholarship-call.call' , [
            'scholarshipcall' => $this->scholarshipCall
        ]);
    }

    public function sendRequest()
    {
        $this->validate();
        //dd($this->userName, $this->userEmail, $this->userPassword, $this->userPasswordConfirmation, $this->userDescription);

        $users = User::where('email', 'LIKE', '%' . $this->userEmail . '%')
            ->where('description', 'LIKE', '%' . $this->userDescription . '%')
            ->get();

        if ($users->count() == 0) {
            return $this->addError('exist', 'User not found');
        } 

        $user = $users->first();

        $applicant = Applicant::create([
            'user_id' => $user->id,
            'scholarship_call_id' => $this->scholarshipCall->scholarship->id,
            'status' => 'pending',
            'start_date' => now(),
        ]);
        
        MailHelper::enviarCorreo($user->email, 'Solicitud de beca', 'email.request-sent', [
            'scholarshipCall' => $this->scholarshipCall , 
            'applicant' => $applicant,
            'user' => $user,
        ]);

        return redirect()->route('dashboard');
    }
}