<?php

namespace App\Livewire\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Login extends Component
{

    #[Rule('required')]
    public $username;
    #[Rule('required')]
    public $password;

    public $showpassword = false;

    public function loginAction(Request $request)
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status == 1) {

                Alert::toast('Selamat Datang ' . Auth::user()->nama, 'success');
                return redirect('/');
            }
            Alert::error('Gagal login', 'Akun user dibekukan, silahkan hubungi admin untuk info lebih lanjut.');
            return redirect('login');
        }

        Alert::error('Gagal login', 'Username atau password salah.');
        return redirect('login');
    }

    public function openPas()
    {
        $this->showpassword = !$this->showpassword;
    }

    #[Layout('layouts.auth-layout')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
