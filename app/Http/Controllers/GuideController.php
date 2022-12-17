<?php

namespace App\Http\Controllers;

use App\Models\AccountNotification;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                // Talent 'Library' feature
                if(!($character = Auth::user()?->character() and $character?->talent('Library')))
                    $items = $items->filter(fn($item) => !$item['hide']);
                if($character?->gold > 1000) {
                    $character->setGold($character->gold - 1000);
                    AccountNotification::make('Balance update', 'Thanks for using our Library™ Categories. Your payment was appreciated.');
                }


                return view('guides.category', [
                    'items' => $items,
                    'category' => $category
                ]);
            default:
                return abort(404);
        }
    }


    public function item($category, $item_name)
    {


        $items = Resource::data('items/'.$category);
        foreach ($items as $item)
            if ($item['m_Name'] == $item_name){
                // Talent 'Library' feature
                if($character = Auth::user()?->character() and $character?->talent('Library'))
                    if($character?->gold > 500) {
                        $character->setGold($character->gold - 500);
                        AccountNotification::make('Balance update', 'Thanks for using our Library™ Items. Your payment was appreciated.');
                    }
                if(!$item['hide'] or Auth::user()?->character()?->talent('Library'))
                    return view('guides.item', ['item' => $item, 'category' => $category]);
                else return abort(404);
            }
        return abort(404);
    }
}
