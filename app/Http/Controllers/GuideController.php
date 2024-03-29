<?php

namespace App\Http\Controllers;

use App\Models\AccountNotification;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Str;
use Symfony\Component\Yaml\Yaml;

class GuideController extends Controller
{
    public function category($category)
    {
        $items = Resource::data("/Items/$category");
        $subcategories = $items->flatMap(function ($item) {
            $categories = explode('/', $item['pathCategory']);
            return count($categories) > 1 ? [$categories[1]] : [];
        })->unique();
        if($subcategory = request()->subcategory) $items = $items->filter(fn($item) => Str::contains($item['pathCategory'], "/$subcategory"));
        // Talent 'Library' feature
        if(!($character = Auth::user()?->character() and $character?->talent('Library')))
            $items = $items->filter(fn($item) => !isset($item['hide']) || !$item['hide']);
        return view('guides.category', [
            'items' => $items,
            'category' => $category,
            'subcategories' => $subcategories
        ]);
    }


    public function item($category, $item_name)
    {
        $items = Resource::data('Items/'.$category);
        foreach ($items as $item)
            if ($item['m_Name'] == $item_name){
                // Talent 'Library' feature
                if($character = Auth::user()?->character() and $character?->talent('Library'))
                    if($character?->gold > 500) {
                        $character->setGold($character->gold - 500);
                        AccountNotification::make('Balance update', 'Thanks for using our Library™ Items. Your payment was appreciated.');
                    }
                if(!isset($item['hide']) || !$item['hide'] or Auth::user()?->character()?->talent('Library'))
                    return view('guides.item', ['item' => $item, 'category' => $category]);
                else return abort(404);
            }
        return abort(404);
    }

    public function find($item)
    {
        if($item = Resource::data('Items')->firstWhere('m_Name', $item)){
            return redirect('/guides/'.explode('/',$item['pathCategory'])[0].'/'.$item['m_Name']);
            //return view('guides.item', ['item' => $item, 'category' => explode('/',$item['pathCategory'])[0]]);
        }
        return abort(404);

    }
}
