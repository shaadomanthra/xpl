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
        
     
        
        return view('appl.social.word.index')
            ->with('word',$w);
    }
}
