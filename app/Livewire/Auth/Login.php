<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $email, $password, $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function  login()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password]))
        {
            session()->regenerate();
            return redirect()->intended(route('products'));
        }

        $this.$this->addError('email', 'Invalid email or password');
    }

    public function render()
    {
        return view('livewire.auth.login') -> layout('livewire.auth.layout');
    }
}
