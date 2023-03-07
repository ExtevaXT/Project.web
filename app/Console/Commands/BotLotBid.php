<?php

namespace App\Console\Commands;

use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\ClaimItem;
use App\Models\Lot;
use App\Models\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class BotLotBid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:lot-bid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make bid on random lot by random bot';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bots = file(resource_path('bots.txt'));
        $name = str_replace(array("\r", "\n"), '', collect($bots)->random());

        $lot = Lot::all()->filter(fn($lot) => $lot->endTime() > Carbon::now() and $lot->bid != $lot->price)->random();
        $bid = rand(1, $lot->price-1);
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();
        if(!in_array($previousBidder->name, $bots)){
            if($previousBidder->account != $lot->character){
                $previousBidder->setGold($previousBidder->gold + $lot->bid);
                AccountNotification::make('Balance update', 'Your bid was outbid', $previousBidder->account);
            }
        }
        //there will be trouble with claim item, bots don't claim them,
        //so probably lot creator could claim it after overtime.
        //need to fix this

        $lot->bid = $bid;
        $lot->bidder = $name;
        $lot->save();
        return Command::SUCCESS;
    }
}
