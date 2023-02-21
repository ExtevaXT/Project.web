<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;

class LoginCheck extends Component
{
    public bool $bool;
    public string $login;
    public function check()
    {
        $this->bool = Account::all()->where('name', $this->login) == null;
    }
    public function render()
    {
        return view('livewire.login-check');
    }
}
