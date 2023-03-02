<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfilePanel extends Component
{
    public $url;
    public function change()
    {
        Auth::user()->settings(['indexProfilePanel' => $this->url]);
    }
    public function render()
    {
        $this->url = Auth::user()->setting('indexProfilePanel');
        return view('livewire.profile-panel');
    }
}
