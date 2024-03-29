<?php

namespace App\Models;

use Carbon\Carbon;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Yaml\Yaml;

class Resource extends Model
{
    public static function data($path)
    {
        $data = collect();
        if(!is_dir($path = public_path("/assets/$path"))) return abort(404);
        $it = new RecursiveDirectoryIterator($path);
        foreach(new RecursiveIteratorIterator($it) as $file) {
            if ($file->getExtension() == 'asset') {
                $asset = str_ireplace("%TAG !u! tag:unity3d.com,2011:",'', file_get_contents($file));
                $asset = str_ireplace("--- !u!114 &11400000",'', $asset);
                $data->push(Yaml::parse($asset)['MonoBehaviour']);
            }
        }
        return $data;
    }

    public static function icon($name)
    {
        $it = new RecursiveDirectoryIterator(public_path("/assets/Icons"));
        foreach(new RecursiveIteratorIterator($it) as $file) {
            if ($file->getExtension() == 'png' and $file->getBasename('.png') == $name) {
                return explode('public',$file->getPathName())[1];
            }
        }
        return abort(404);
    }
    public static function attachments($metadata)
    {
        $attachments = collect();
        foreach (self::data('items/attachments') as $attachment){
            foreach (str_split($metadata) as $group => $id)
                if($group == $attachment['attachmentMetaGroup'] and $id == chr($attachment['attachmentMetaId']))
                    $attachments->push($attachment);
        }
        return $attachments;
    }

    public static function quest($name, $lua = true)
    {
        if($lua) $name = explode('"', $name)[1];
        $db = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '',
            file_get_contents(resource_path().'/ds_dump.json')), true );
        return array_values(array_filter($db['items'], function ($item) use ($name){
            return $item['fields'][0]['value'] == $name;
        }))[0]['fields'];
    }

    public static function item($item)
    {
        $args = [
            'ammoType',
            'damage',
            'clipSize',
            'distance',
            'rateOfFire',
            'reloadTime', 'tacticalReloadTime',
            'spread', 'hipSpread',
            'recoil', 'horizontalRecoil',
            'drawTime',
            'aimSwitch',
            'startDamage', 'damageDecreaseStart', 'endDamage', 'damageDecreaseEnd', 'startDamage',
            'recoilGain', 'damageDistant', 'wiggle', 'tickSpreadMultiplierReduction',
            'Bonus', 'heal', 'speedModifier', 'Protection', 'Accumulation', 'reactionTo', 'DmgFactor',
            'compatible',
            'charge','Scan','range',
            'common','strong','piercing','bloodlustChance',
            'lifetime','explosion','flashTime',
            'effectiveness', 'size',
            'bleeding','stoppingPower','combustion','numBullets','absoluteDamage',
        ];
        $item = array_filter($item, function ($value, $argument) use ($args){
            return (Str::contains($argument, $args) and $value != 0);
        },ARRAY_FILTER_USE_BOTH);
        return $item;
    }
    public static function date($date)
    {
        return Carbon::parse($date)->tz('Asia/Yekaterinburg')->format('d M Y | H:i');
    }

    public static function commits()
    {
        $commits = collect(json_decode(file_get_contents(resource_path('commits.json'))));
        if($commits->where('repository','Project.web')->count() < 3 or
            $commits->where('repository','Project.web')->count() < 3){
            $web = collect(GitHub::repo()->commits()->all('ExtevaXT','Project.web', []))->take(3);
            $unity = collect(GitHub::repo()->commits()->all('ExtevaXT','Project.unity', []))->take(3);
            $formatter = fn($commit) => [
                'author' =>$commit['commit']['author']['name'],
                'message' => $commit['commit']['message'],
                'date'=>$commit['commit']['author']['date'],
                'url'=>$commit['html_url'],
            ];
            return [
                'request' => true,
                'unity' =>  $unity->map($formatter),
                'web' => $web->map($formatter),
            ];
        }
        else
            return [
                'request'=> false,
                'commits' => $commits->where('repository','Project.web')->pop(3)
                    ->concat($commits->where('repository','Project.unity')->pop(3))
            ];
    }
}
