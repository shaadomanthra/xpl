<?php

namespace PacketPrep\Models\Social;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'word',
        'meaning',
        'star',
        'sentence',
        'mnemonic',
        'explanation',
        'picture',
        'updat'
        // add all other fields
    ];
}
