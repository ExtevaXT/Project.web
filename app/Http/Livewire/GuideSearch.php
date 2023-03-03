<?php

namespace App\Http\Livewire;

use App\Models\Resource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class GuideSearch extends Component
{
    public $input;
    protected $result;
    protected $queryString = ['input'];
    public function render()
    {
        $this->search();
        return view('livewire.guide-search', ['result' => $this->result]);
    }
//    public function updatedInput()
//    {
//        $this->search();
//    }
//    public function hide()
//    {
//        $this->input = null;
//    }
    public function search()
    {
        if($this->input)
        $this->result = (Resource::data('Items')->filter(function ($item) {
            //quick commands
            if(Str::startsWith($this->input, '/c'))
                return Str::contains($item['pathCategory'], explode(' ', Str::replace('/c', '', $this->input)) ,true);
            if(Str::startsWith($this->input, '/n'))
                return Str::contains($item['fullName'], explode(' ', Str::replace('/n', '', $this->input)) ,true);
            //otherwise all
            return Str::contains($item['fullName'], $this->input, true) or
                Str::contains($item['pathCategory'], explode(' ', $this->input) ,true);
        }));
    }
}
