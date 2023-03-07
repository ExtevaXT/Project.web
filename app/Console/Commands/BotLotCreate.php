<?php

namespace App\Console\Commands;

use App\Models\ClaimItem;
use App\Models\Lot;
use App\Models\Resource;
use Illuminate\Console\Command;

class BotLotCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:lot-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create random lot by random bot';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bots = file(resource_path('bots.txt'));
        $name = str_replace(array("\r", "\n"), '', collect($bots)->random());
        $item = (object)Resource::data('Items')->random();
        $claim_item = ClaimItem::create([
            'name'=>$item->m_Name,
            'amount'=> 1,
            'durability'=> $item?->maxDurability != null ? rand(1,$item->maxDurability) : 0,
            'ammo'=> 0,
            'metadata'=> '00000',
            'claimed'=>false,
        ]);
        $time = [12,24,36,48];
        $multiplier = rand(5, 15) / 10;
        $price = $item?->price ?? 10000 * $multiplier;
        Lot::create([
            'character' => $name,
            'item'=> $claim_item->id,
            'time' => $time[array_rand($time)],
            'bid' => $price - rand(1, $price - 1),
            'price' => $price,
            'bidder' => $name,
        ]);
        echo $name . ' created '. $item->m_Name .' for '. $price;
        return Command::SUCCESS;
    }
}
