<?php

namespace PacketPrep\Models\Library;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name',
        'video',
        'user_id',
        'repository_id',
        'structure_id',
        'status',
        // add all other fields
    ];

    public function structure()
    {
        return $this->belongsTo('PacketPrep\Models\Library\Structure');
    }

    public function user(){
    	return $this->belongsTo('PacketPrep\User');
    }

    public function getThumbnail($id){

        if(url_exists('https://player.vimeo.com/video/'.$id))
            $type = 'vimeo';
        if(youtube_video_exists($id))    
            $type = 'youtube';

        if($type=='vimeo')
            return unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"))[0]['thumbnail_medium'];
        else
            return 'https://img.youtube.com/vi/'.$id.'/0.jpg';
            
    }
}
