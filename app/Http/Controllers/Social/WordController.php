<?php

namespace PacketPrep\Http\Controllers\Social;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Social\Word;

class WordController extends Controller
{
    //

    public function index(Word $word)
    {
        
        $id = rand(1,4150);
        $w = $word->where('id',$id)->first();
        $pieces = explode(";",$w->meaning);
        $w->meaning = ucfirst(trim($pieces[0]));
        
        //rgb(34, 112, 147)rgb(179, 57, 57)rgb(106, 176, 76)
        if(date('l') == 'Sunday'){
            $r = '106'; $b = '176'; $g='76';
        }elseif(date('l') == 'Friday'){
            $r = '179'; $b = '57'; $g='57';
        }elseif(date('l') == 'Thursday'){
            $r = '34'; $b = '112'; $g='147';
        }elseif(date('l') == 'Wednesday'){
            $r = '196'; $b = '69'; $g='105';
        }elseif(date('l') == 'Tuesday'){
            $r = '87'; $b = '75'; $g='144';
        }
        elseif(date('l') == 'Monday'){
            $r = '0'; $b = '98'; $g='102';
        }else{
            $r = '111'; $b = '30'; $g='81';
        }

        $color['a'] = 'rgba('.$r.', '.$b.', '.$g.', 0.9)';
        $color['b'] = 'rgba('.$r.', '.$b.', '.$g.', 1)';

        
        return view('appl.social.word.index')
            ->with('word',$w)->with('color',$color);
    }
}
