<?php

namespace App\Console\Commands;

use App\Models\AccountNotification;
use App\Models\Character;
use App\Models\Lot;
use Illuminate\Console\Command;

class BotLotBuyout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:lot-buyout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bots = file(resource_path('bots.txt'));
        $name = str_replace(array("\r", "\n"), '', collect($bots)->random());

        $lot = Lot::all()->random();
        $previousBidder = Character::all()->where('name', $lot->bidder)->first();
        if(!in_array($previousBidder->name, $bots)){
            if($previousBidder->account != $lot->character){
                $previousBidder->setGold($previousBidder->gold + $lot->bid);
                AccountNotification::make('Balance update', 'Your bid was outbid', $previousBidder->account);
            }
        }
        $lot->bid = $lot->price;
        $lot->bidder = $name;
        $lot->save();
        $item = $lot->item();
        $item->update(['claimed'=>true]);
        return Command::SUCCESS;
    }
}
