<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Character;
use App\Models\CharacterAchievement;
use App\Notifications\DiscordBotMessage;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Util\Json;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function log()
    {
        $url = 'https://discordapp.com/api/v9/channels/1023240443145764894/messages';
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $url,
            CURLOPT_HTTPHEADER     => array('Authorization: Bot '. config('services.discord')['token']),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_VERBOSE        => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return view('chat',['log'=>array_reverse(json_decode($response, true))]);
    }

    public function contact(Request $request)
    {
        $request = $request->validate([
            'g-recaptcha-response' => 'recaptcha',
            'name' =>'required',
            'message' =>'required',
        ]);
        Notification::route('discord', '1029657585177079838')
            ->notify(new DiscordBotMessage($request['name'].': '. $request['message']));
        return back();
    }

    public function ranking(Request $request)
    {
        $filter = $request->query('filter');
        $search = $request->query('search');
        $characters = [];
        // Helper for accessing filters
        foreach (Character::all() as $character){
            $characters[] = (object)[
                'name' => $character->name,
                'account' => $character->account,
                'level' => $character->level,
                'achievements' => CharacterAchievement::where('character', $character->name)->count(),
                'trophies' =>  CharacterAchievement::where('character', $character->name)->sum('reward'),
                'online' => Carbon::parse($character->lastsaved)->format('d M Y'),
                'joined' => Carbon::parse(Account::firstWhere('name', $character->account)->created_at)->year,
                'kda' => round(rand(1, 200)/100, 2)
            ];
        }
        $characters = collect($characters)->sortBy($filter, 0, true);
        // Search
        if($search!=null){
            $characters = $characters->filter(function ($item) use ($search) {
                // replace stristr with your choice of matching function
                return false !== stristr($item->name, $search);
            });
        }
        return view('ranking', compact('characters'));
    }

    public function index()
    {
        // CHECK UDP 91.197.1.60:7777
        // OR
        // CHECK PROCESS ON SERVER
        $status = (bool)shell_exec('pidof ./headless.x86_64');
        return view('index', [
            'unity' => GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []),
            'web' => GitHub::repo()->commits()->all('ExtevaXT','Project.web', []),
            'status' => $status,
        ]);
    }







}
