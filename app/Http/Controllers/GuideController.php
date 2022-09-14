<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function category($category)
    {
        if(($category == 'achievements') or
            ($category == 'auction') or
            ($category == 'ranking') or
            ($category == 'talents'))
            return view('guides.'.$category);
        else{
            $item_filler = [];
//            Make above like top
            switch ($category) {
                case 'anomaly':
                    $item_filler[] = [
                        'title' => 'Blackhole',
                        'description' => 'Gravitational anomaly',
                        'content' => 'A common and dangerous anomaly, which snatches its victims up in the air and spins them at a breakneck speed.
                        The exact nature of the Whirligig remains unknown.
                        The anomaly can be recognized by a light whirlwind of dust above and by body fragments scattered in the vicinity.
                        Victims caught on its outer rim, far enough from the maximum effect zone at the center, can escape the anomaly with relatively minor injuries.'
                    ];
                    break;
                case 1:
                    echo "i равно 1";
                    break;
                case 2:
                    echo "i равно 2";
                    break;
            }
            return view('guides.category', $item_filler);
        }


    }
}
