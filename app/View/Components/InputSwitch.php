<?php

namespace App\View\Components;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class InputSwitch extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $label;
    public $checked;
    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
        $this->checked = Account::find(Auth::user()->id)->setting($name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-switch');
    }
}
