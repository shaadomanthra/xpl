<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Youtube;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('appl.video.video');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return view('appl.video.video');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \auth::user();
        $title = $user->name.' - Introduction';
        $video = Youtube::upload($request->file('video')->getPathName(), [
            'title'       => $title,
            'description' => 'This is a self introduction video of the xplore student',
            'tags'        => ['api', 'youtube'],

        ],'unlisted');
         
        $id = $video->getVideoId();
        
        $user->video =$id;
        $user->save();

        return redirect()->route('video.upload');
    }


    public function save(Request $request)
    {
        $user = \auth::user();
        $url = $request->get('url');
        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        $id = $my_array_of_vars['v'];
        
        $user->video =$id;
        $user->save();

        return redirect()->route('video.upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageupload(Request $request)
    {
        $request = request();
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $filename = '../storage/app/public/articles/imagecam.jpg';
        file_put_contents($filename, base64_decode($image));
        
        echo $filename;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
