<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;
use function PHPUnit\Framework\isEmpty;

class LoginCheck extends Component
{
    public bool $bool;
    public string $login;
    public function check()
    {
        $this->bool = false;
        if(isset($this->login)) $this->bool = Account::all()->where('name', $this->login)->isEmpty();
    }
    public function render()
    {
        return view('livewire.login-check');
    }
}
