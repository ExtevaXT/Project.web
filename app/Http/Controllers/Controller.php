<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Notifications\DiscordBotMessage;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Notification;

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
        Notification::route('discord', '1029657585177079838')
            ->notify(new DiscordBotMessage($request['name'].': '. $request['message']));
        return back()->with(['success' =>true]);
    }

    public function ranking(Request $request)
    {
        $filter = $request->query('filter');
        $characters = Character::all()->sortBy($filter, 0, true);
        return view('ranking', compact('characters'));
    }

}
