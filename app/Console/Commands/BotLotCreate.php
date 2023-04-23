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
    protected $signature = 'bot:lot-create {amount}';
    //TODO remove
    public int $DEF_PRICE = 10000;

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
        for ($i = 0; $i <= $this->argument('amount'); $i++) {
            $bots = file(resource_path('bots.txt'));
            $name = str_replace(array("\r", "\n"), '', collect($bots)->random());
            $item = (object)Resource::data('Items')->random();
            $claim_item = ClaimItem::create([
                'name' => $item->m_Name,
                'amount' => 1,
                'durability' => $item?->maxDurability != null ? rand(1, $item->maxDurability) : 0,
                'ammo' => 0,
                'metadata' => '00000',
                'claimed' => false,
            ]);
            $time = [12, 24, 36, 48];
            $multiplier = rand(50, 150) / 100;
            $price = ($item?->price ?? $this->DEF_PRICE) * $multiplier;
            $lot = Lot::create([
                'character' => $name,
                'item' => $claim_item->id,
                'time' => $time[array_rand($time)],
                'bid' => $price - rand(1, $price - 1),
                'price' => $price,
                'bidder' => $name,
            ]);
            echo $lot->id.': '. $name . ' created ' . $item->m_Name . ' for ' . $price ." ($multiplier x) " . "\n";
        }
        return Command::SUCCESS;
    }
}
