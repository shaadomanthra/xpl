<?php

namespace PacketPrep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

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

   


    public function save(Request $request)
    {
        $user = \auth::user();
        $url = $request->get('url');
        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        $id = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        if(isset($matches[0])){
            $id = $matches[0];
        
        $user->video =$id;
        $user->save();

        Cache::forget('id-' . $user->id);
        Cache::forever('id-'.$user->id,$user);
    }
        else{
            flash('Invalid URL. Kindly reach out to administrator if the error is persistent.')->error();
        }
        
        

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

        $filename = 'imagecam.jpg';
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
