<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\ClaimItem;
use App\Models\Lot;
use App\Models\Resource;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Bot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with bots';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bots = file(resource_path('bots.txt'));
        foreach ($bots as $bot){
            $name = str_replace(array("\r", "\n"), '',$bot);
            Account::updateOrCreate(['name' => $name, 'password' => Hash::make(env('APP_KEY'))]);
            DB::table('characters')->updateOrInsert([
                'name' => $name,
                'account' => $name,
                'level' => '100',
                'experience' => '0',
                'gold' => '999999999',
                'faction' => 'Neutral',
                'online' => '0',
                'deleted' => '0',
            ]);
            DB::table('character_skills')->updateOrInsert([
                'character' => $name
            ]);
            echo "Created $name \n";
        }
        return Command::SUCCESS;
    }
}
