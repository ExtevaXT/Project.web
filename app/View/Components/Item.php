<?php

namespace App\View\Components;

use App\Models\Resource;
use Illuminate\View\Component;

class Item extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $icon;
    public $amount;
    public $metadata;

    public $size;
    public function __construct($name, $amount = 1, $metadata = '00000', $size = 100)
    {
        $this->name = $name;
        $this->amount = $amount;
        $this->metadata = $metadata;
        $this->icon = Resource::icon($name);
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.item');
    }
}
