<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Character;
use App\Models\CharacterAchievement;
use App\Models\Resource;
use App\Notifications\DiscordBotMessage;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Util\Json;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function messages($channel){
        $url = "https://discordapp.com/api/v9/channels/$channel/messages";
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
        return array_reverse(json_decode($response, true));
    }
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
        return view('chat',['log'=>$this->messages(1023240443145764894)]);
    }

    public function contact(Request $request)
    {
        $val = $request->validate([
            'name' =>'required',
            'message' =>'required',
        ]);
        if(str_contains($val['message'], 'http')) return 'Fuck you';
        Notification::route('discord', '1029657585177079838')
            ->notify(new DiscordBotMessage($val['name'].': '. $val['message'].
                "\n IP: ". $request->ip() .
                "\n USER AGENT: ". $request->userAgent().
                "\n ACCOUNT: ". $request->user()->name
            ));
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
                'online' => Carbon::parse($character->lastsaved)->format('Y.m.d'),
                'joined' => Carbon::parse(Account::firstWhere('name', $character->account)->created_at)->year,
                'kda' => $character->deaths != 0 ? $character->kills / $character->deaths : 0
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

    public function faction()
    {
        $rewards = Resource::data('Items')->random(18)->map(fn($item) => [
            'name'  => $item['m_Name'],
            'amount' =>  rand(1, $item['maxStack'] ?? 1),
            'metadata' =>'00000'
        ]);
        return view('faction', compact('rewards'));
    }

    public function index()
    {
        // CHECK UDP 91.197.1.60:7777
        // OR
        // CHECK PROCESS ON SERVER
        $status = (bool)shell_exec('pidof ./headless.x86_64');
        $announcements = $this->messages(1042157595386970132);
        $releases = GitHub::repo()->releases()->all('ExtevaXT','Project.unity', []);
        return view('index', [
            'unity' => collect(GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []))->take(3) ,
            'web' => collect(GitHub::repo()->commits()->all('ExtevaXT','Project.web', []))->take(3),
            'status' => $status,
            'announcement' =>  end($announcements),
            'release' =>  end($releases)
        ]);
    }

    public function commits()
    {
        return collect([
            'commits' => collect(GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []))->take(3)
                ->map(fn($commit) => [
                    'message' => $commit['commit']['message'],
                    'author' => $commit['commit']['author']['name'],
                    'date' => Carbon::parse($commit['commit']['author']['date'])->tz('Asia/Yekaterinburg')->format('d M Y | H:i'),
                ])
        ])->toJson();

    }







}
