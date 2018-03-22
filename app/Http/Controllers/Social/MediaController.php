<?php

namespace PacketPrep\Http\Controllers\Social;

use Illuminate\Http\Request;
use PacketPrep\Http\Controllers\Controller;
use PacketPrep\Models\Social\Social;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Social $social)
    {
        $this->authorize('view', $social);

        if(\Auth::guest())
            return redirect('login');
        
        /*$socials = Social::latest()->get()->groupBy(function($item)
                        {
                          return $item->schedule;
                        }); */

        $socials = $social->orderBy('schedule','desc')
                    ->paginate(config('global.no_of_records'));
        
        return view('appl.social.media.index')
            ->with('social',$social)
            ->with('socials',$socials);
    }

    public function social(){
        if(\auth::user()->checkRole(['administrator','editor','social-media-moderator','social-media-writer','blog-moderator','blog-writer','employee'])){

            $socials = Social::where('status',1)->orderBy('schedule','desc')->get()->groupBy(function($item)
                        {
                          return $item->schedule;
                        });

            return view('appl.social.index')->with('socials',$socials); 
        }
        else
            return abort('403','Unauthorized Access');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Social $social)
    {
        $this->authorize('create', $social);


        return view('appl.social.media.createedit')
                ->with('social',$social)
                ->with('jqueryui',true)
                ->with('stub','Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $social = new Social;
            $social->user_id_moderator = $request->user_id_moderator;
            $social->user_id_writer = $request->user_id_writer;
            $social->network= $request->network;
            $social->content = ($request->content)?$request->content:' ';
            $social->image = ($request->image)?$request->image:' ';
            $social->status= $request->status;
            $social->schedule= $request->schedule;
            $social->save();

            flash('A new Socialmedia post is created!')->success();
            return redirect()->route('media.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                flash('Some error is there kindly recheck!')->error();
                 return redirect()->back()->withInput();;
            }
        }
    }


    public function image_remove(){
        
        $file = $_REQUEST['image'];
        unlink(trim($file));
    }

    public function image_upload(){

        $request = new Request;

        $status = array();
        $target_dir = "img/Social/";
        if(\auth::guest())
            $username = $request->username;
        else 
            $username = \auth::user()->username;

        if(isset($_FILES["fileToUpload"])){
        $target_file = $target_dir .$username.'_'.time().'_'. basename($_FILES["fileToUpload"]["name"]);
        $status['image'] = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $status['message'] = "File is an image - " . $check["mime"] . ".";
                $status['success'] = 1;

            } else {
                $status['message'] = "File is not an image.";
                $status['success']  = 0;
                 return $status;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $status['message'] = "Sorry, file already exists.";
            $status['success']  = 0;
             return $status;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 10000000) {
            $status['message'] = "Sorry, your file is too large.";
            $status['success']  = 0;
             return $status;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $status['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $status['success']  = 0;
            return $status;
        }
        
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $status['message'] = "Successfully uploaded";
                $status['success']  = 1;
            } else {
                $status['message'] = "Sorry, there was an error uploading your file.";
                $status['success']  = 0;
            }

        }

        if($status['success'])
            echo $status['image'];
        else
            echo 0;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($social_slug)
    {
        $social = Social::where('slug',$social_slug)->first();
        return view('appl.social.media.show')
                    ->with('social',$social)
                    ->with('stub',$social->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $social = Social::where('id',$id)->first();
        $this->authorize('edit', $social);
        if($social)
            return view('appl.social.media.createedit')
                    ->with('jqueryui',true)
                    ->with('social',$social)
                    ->with('stub','Update');
        else
            abort(404);
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
        try{
            $social = Social::where('id',$id)->first();
            $social->user_id_moderator = $request->user_id_moderator;
            $social->user_id_writer = $request->user_id_writer;
            $social->network= $request->network;
            $social->content = ($request->content)?$request->content:' ';
            $social->image = ($request->image)?$request->image:' ';
            $social->status= $request->status;
            $social->schedule= $request->schedule;
            $social->save();

            flash('Socialmedia post  successfully updated!')->success();
            return redirect()->route('media.index');
        }
        catch (QueryException $e){
           $error_code = $e->errorInfo[1];
            if($error_code == 1062){
                 flash('Some error is there kindly recheck!')->error();
                 return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $social = new Social;
        $this->authorize('create', $social);
        Social::where('id',$id)->first()->delete();
        flash('Social Successfully deleted!')->success();
        return redirect()->route('media.index');
    }
}
