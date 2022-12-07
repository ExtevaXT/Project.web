<?php

namespace App\View\Components;

use App\Models\Account;
use App\Models\Lot;
use Illuminate\View\Component;

class AuctionTable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public $lots;

    public function __construct($id, $lots)
    {
        $this->id = $id;
        if(Account::auth() and $character = Account::auth()->character()) {
            $lots = match ($id) {
                'all' => $lots,
                'my_lots' => $lots->where('character', $character->name),
                'my_bids' => $lots->where('bidder', $character->name)->where('character', '!=', $character->name),
            };
        }
        $this->lots = $lots;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auction-table');
    }
}
