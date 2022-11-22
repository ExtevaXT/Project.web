<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;

class Resource extends Model
{
    public static function data($path)
    {
        $data = collect();
        $files = glob(resource_path()."/assets/$path/*.*", GLOB_BRACE);
        foreach($files as $file) {
            $data->push(Yaml::parse(str_ireplace(config('app.trim'),'', file_get_contents($file)))['MonoBehaviour']);
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
}
