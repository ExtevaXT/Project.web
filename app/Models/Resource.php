<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Yaml\Yaml;

class Resource extends Model
{
    public static function data($path)
    {
        $data = collect();
        if(!is_dir($path = resource_path()."/assets/$path")) return abort(404);
        $it = new RecursiveDirectoryIterator($path);
        foreach(new RecursiveIteratorIterator($it) as $file) {
            if ($file->getExtension() == 'asset') {
                $data->push(Yaml::parse(str_ireplace(config('app.trim'),'', file_get_contents($file)))['MonoBehaviour']);
            }
        }
        return $data;
    }

    public static function icons()
    {
        $item_icons = [];
        foreach (Storage::disk('public_real')->directories('img/icon') as $category){
            foreach (Storage::disk('public_real')->files($category) as $icon){
                $item_icons[basename($icon, '.png')] = $icon;
            }
        }
        return $item_icons;
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
}
