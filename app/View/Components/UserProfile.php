<?php

namespace App\View\Components;

use App\Models\Account;
use App\Models\Character;
use Illuminate\View\Component;

class UserProfile extends Component
{
    public Account $account;
    public mixed $character;
    public int $size;
    public bool $all;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $size = 64, $all = true)
    {
        $this->account = Account::all()->where('name', $name)->first();
        $this->character = $this->account->character();
        $this->size = $size;
        $this->all = $all;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-profile');
    }
}
