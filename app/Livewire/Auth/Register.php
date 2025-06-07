<?php

namespace App\Livewire\Auth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $phone = '';
    public $role = 'staff';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,manager,staff',
    ];

    protected $messages = [
        'name.required' => 'Numele este obligatoriu.',
        'name.min' => 'Numele trebuie să aibă cel puțin 3 caractere.',
        'email.required' => 'Email-ul este obligatoriu.',
        'email.email' => 'Adresa de email nu este validă.',
        'email.unique' => 'Această adresă de email este deja folosită.',
        'password.required' => 'Parola este obligatorie.',
        'password.min' => 'Parola trebuie să aibă cel puțin 6 caractere.',
        'password.confirmed' => 'Confirmarea parolei nu se potrivește.',
        'phone.max' => 'Numărul de telefon este prea lung.',
        'role.required' => 'Rolul este obligatoriu.',
        'role.in' => 'Rolul selectat nu este valid.',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'role' => $this->role,
            'active' => true,
        ]);

        Auth::login($user);

        session()->flash('message', 'Contul a fost creat cu succes!');

        return redirect()->intended('/products');
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('livewire.auth.layout');
    }
}
