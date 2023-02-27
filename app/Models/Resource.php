<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Yaml\Exception\ParseException;
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

    public static function bonus($bonus)
    {
        $bonus = ucfirst(str_replace('Bonus', '', $bonus));
        $bonus = str_replace('Accumulation', 'Emission', $bonus);

        $split = preg_split('/(?=[A-Z])/',$bonus);
        if(!str_contains($bonus, 'Recovery') and !str_contains($bonus, 'Effiency')) $split = array_reverse($split);
        $bonus = implode(' ', $split);

        $bonus = str_replace('Factor Damage', 'Damage Factor', $bonus);
        $bonus = str_replace('Weight', 'Carrying Capacity', $bonus);
        $bonus = str_replace('Artefact', 'Artefact Slots', $bonus);
        return $bonus;
    }

    public static function date($date)
    {
        return Carbon::parse($date)->tz('Asia/Yekaterinburg')->format('d M Y | H:i');
    }
}
