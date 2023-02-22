<?php

namespace App\Http\Livewire;

use App\Models\Resource;
use Livewire\Component;

class GuideSearch extends Component
{
    public $input;
    protected $result;
    public function render()
    {
        return view('livewire.guide-search', ['result' => $this->result]);
    }
//    public function updatedInput()
//    {
//        $this->search();
//    }
    public function hide()
    {
        $this->input = null;
    }
    public function search()
    {
        if($this->input)
        $this->result = (Resource::data('Items')->filter(function ($item) {
            return false !== stristr($item['fullName'], $this->input);
        }))->take(8);
    }
}
