<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;

class GuideController extends Controller
{
    public function category($category)
    {
        switch ($category) {
            case 'achievements':
            case 'auction':
            case 'ranking':
            case 'talents':
            case 'anomalies':
                return view('guides.'.$category);
            case 'artefacts':
            case 'equipment':
            case 'weapons':
            case 'attachments':
            case 'other':
                $items = Resource::data("/items/$category");
                return view('guides.category', ['items' => $items, 'category' => $category]);
            default:
                return back();
        }
    }


    public function item($category, $item_name)
    {
        $items = Resource::data('items/'.$category);
        foreach ($items as $item){
            if ($item['m_Name'] == $item_name){
                return view('guides.item', ['item' => $item, 'category' => $category]);
            }
        }
        return back();
    }
}
