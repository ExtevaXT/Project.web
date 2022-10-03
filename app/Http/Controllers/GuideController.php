<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class GuideController extends Controller
{
    public function category($category)
    {
        if(($category == 'achievements') or
            ($category == 'auction') or
            ($category == 'ranking') or
            ($category == 'talents') or
            ($category == 'anomalies'))
            return view('guides.'.$category);
        elseif (($category == 'artefacts') or
            ($category == 'equipment') or
            ($category == 'weapons') or
            ($category == 'attachments') or
            ($category == 'other'))
        {
            $files = glob(resource_path().'/assets/yaml/'.$category.'/*.*', GLOB_BRACE);
            $items = [];
            foreach($files as $file) {
                $items[] = Yaml::parse(str_ireplace(config('app.trim'),'', file_get_contents($file)))['MonoBehaviour'];
            }
//            $item = Yaml::parse(str_ireplace($trim,'', file_get_contents(resource_path('assets/yaml/Crystal.asset'))));

            return view('guides.category', ['items' => $items, 'category' => $category]);
        }
        return back();


    }

    public function item($category, $item_name)
    {
        $trim = '%YAML 1.1
%TAG !u! tag:unity3d.com,2011:
--- !u!114 &11400000';
        $files = glob(resource_path().'/assets/yaml/'.$category.'/*.*', GLOB_BRACE);
        $items = [];
        foreach($files as $file) {
            $items[] = Yaml::parse(str_ireplace($trim,'', file_get_contents($file)))['MonoBehaviour'];
        }
        foreach ($items as $item){
            if ($item['m_Name'] == $item_name){
                return view('guides.item', ['item' => $item, 'category' => $category]);
            }
        }
        return back();
    }
}
